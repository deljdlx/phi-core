<?php

namespace Phi\Module\DOMTemplate;




use Phi\Traits\Collection;
use Phi\Traits\Introspectable;

class Descriptor extends Fragment
{

    use Introspectable;
    use Collection;

    const XPATH_TEMPLATE='//metadata/link[@rel="CapitalSite/Template"]';
    const XPATH_DATASOURCE='//metadata/link[@rel="CapitalSite/DataSource"]';
    const XPATH_DATANODE='//metadata/script[@type="data/json"]';


    protected $debugMode=true;


    protected $descriptor='';
    protected $compiledDescriptor='';

    protected $domDescriptor;
    protected $template;

    protected $dataSource;
    protected $data=array();


    protected $dataLoading=true;



    protected $packages=array(
        '\CapitalSite\Component',
        '\CapitalSite\Asset',
    );



    public function __construct($descriptor=null) {
        libxml_use_internal_errors(true);
        if($descriptor) {
            $this->descriptor=$descriptor;
        }
        else {
            $defaultTemplate=$this->getDefinitionFolder().'/'.\CapitalSite\Frontend\getFromConfiguration('defaultDescriptorFile');
            if(is_file($defaultTemplate)) {
                $this->descriptor=obinclude($defaultTemplate);
            }
        }
    }



    public function loadDescriptorByName($descriptorName){
        $file=$this->getDefinitionFolder().'/template/'.$descriptorName;

        if(is_file($file)) {
            $this->descriptor=obinclude($file);
            return $this;
        }
        else {
            throw new \Capital\Exception('Descriptor '.$descriptorName.'does not exist');
        }
    }




    public function loadDataSource($url, $variableName) {
        $json=file_get_contents($url);
        $this->data[$variableName]=json_decode($json);
    }

    public function importData($name, $uri) {

        $routerClassName='\CapitalSite\Configuration\GlobalRouter';


        if(class_exists($routerClassName)) {

            $router=new $routerClassName;
            $request=new RouterRequest(array(
                'REQUEST_URI'=>$uri,
                'REQUEST_METHOD'=>'GET',
            ));
            $buffer=$router->ob_run($request);


            if($buffer!=='') {
                if($data=json_decode($buffer)) {
                    $this->data[$name]=$data;
                }
                else {
                    $this->data[$name]=$buffer;
                }

                return $this->data[$name];

            }
        }

        return false;

    }





    public function setData($variableName, $data) {
        $this->data[$variableName]=$data;
    }

    //=======================================================


    public function setVariables(array $variables) {
        $this->data=$variables;
        return $this;
    }

    public function setVariable($name, $value) {
        $this->data[$name]=$value;
        return $this;
    }


    public function &getVariable($name) {
        if(isset($this->data[$name])) {
            return $this->data[$name];
        }
        else {
            $this->data[$name]=null;
            return $this->data[$name];
        }
    }


    public function getVariables() {
        return $this->data;
    }


    //=======================================================








    public function getLayoutReference() {
        $xPath=new DOMXPath($this->domDescriptor);
        $query=static::XPATH_TEMPLATE;
        $templateNodes=$xPath->query($query);

        if($templateNodes->length) {
            $templateNode=$templateNodes->item(0);
            $templateReference=$templateNode->getAttribute('href');
            return $templateReference;
        }
    }

    public function getLayoutByReference($reference) {

        $componentData=explode('/', trim($reference));
        $componentName=$componentData[0];
        $componentTemplate=$componentData[1];

        foreach ($this->packages as $namespace) {

            $className=$namespace.'\Layout\\'.$componentName;
            if(class_exists($className)) {
                $layout=new $className();
                $layout->loadTemplate($componentTemplate.'.php');
                return $layout;
            }
        }

            throw new Exception('Can not load template "'.$reference.'"');
    }










    public function getComponentFromNode($node) {
        $componentName=$node->getAttribute('name');

        $className=str_replace('.', '\\', $componentName);


        if(class_exists($className)) {
            $component=new $className;
            return $component;
        }
    }




    public function enableForeignDataLoading($value=true) {
        $this->dataLoading=$value;
        return $this;
    }




    public function loadDescriptorDatasource() {
        $xPath=new DOMXPath($this->domDescriptor);
        $query=static::XPATH_DATASOURCE;
        $dataSourceNodes=$xPath->query($query);

        if($dataSourceNodes->length) {
            foreach ($dataSourceNodes as $dataSourceNode) {
                $dataSourceNode=$dataSourceNode;
                $url=$dataSourceNode->getAttribute('href');
                $variableName=$dataSourceNode->getAttribute('data-bind');
                $this->loadDataSource($url, $variableName);
            }
        }
        //=====================================================
        //extraction des noeuds data
        $xPath=new DOMXPath($this->domDescriptor);
        $query=static::XPATH_DATANODE;
        $dataNodes=$xPath->query($query);

        if($dataNodes->length) {
            foreach ($dataNodes as $dataNode) {
                $data=json_decode($dataNode->textContent, true);
                $variableName=$dataNode->getAttribute('data-bind');
                $this->data[$variableName]=$data;

            }
        }

        return $this;

        //=====================================================
    }

    public function compile() {
        $this->domDescriptor=new DOMDocument('1.0', 'utf-8');
        $this->domDescriptor->loadHTML('<?xml encoding="utf-8" ?>'.$this->descriptor, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD);


        //chargement des data========================================
        if($this->dataLoading) {
            $this->loadDescriptorDatasource();
        }



        $query='//component';
        $xPath=new DOMXPath($this->domDescriptor);
        $componentNodes=$xPath->query($query);


        if($componentNodes->length) {



            foreach ($componentNodes as $componentNode) {
                $component=$this->getComponentFromNode($componentNode);


                $component->debug($this->debugMode);





                $componentOutput='';

                if(!$component || !($component instanceof \CapitalSite\Frontend\Bridge\Component)) {
                    $componentName=$componentNode->getAttribute('name');
                    $component=new Error();
                    $component->setVariable('componentName', $componentName);
                    $componentOutput=$component->encapsulateHTML($component->render());
                }
                else {
                    //extraction des paramètres s'il y en a
                    $parametersXpath=new DOMXPath($this->domDescriptor);
                    $query=$componentNode->getNodePath().'/meta[@data-parameter]';



                    $parametersNodes=$parametersXpath->query($query);
                    if($parametersNodes->length) {
                        //on extracte les valeurs des paramètres
                        foreach ($parametersNodes as $parameterNode) {

                            $parameterName=(string) $parameterNode->getAttribute('data-parameter');
                            $parameterValue=html_entity_decode((string) $parameterNode->getAttribute('data-value'));

                            if(preg_match('`\{\{.+\}\}`', $parameterValue)) {

                                $data=$this->data;

                                $valueReference=null;

                                $parameterValue=preg_replace_callback('`\{?\{\{(.+?)\}\}\}?`', function($matches) use($data, &$valueReference) {


                                    $variables=explode('.', $matches[1]);
                                    $currentVar=null;

                                    $returnValue=$matches[0];
                                    $rootVariable=array_shift($variables);
                                    if(isset($this->data[$rootVariable])) {
                                        $currentVar=$this->data[$rootVariable];


                                        foreach ($variables as $attribute) {
                                            if(is_array($currentVar) && isset($currentVar[$attribute])) {
                                                $currentVar=$currentVar[$attribute];
                                            }

                                            elseif(($currentVar instanceof \stdClass) && isset($currentVar->$attribute)) {
                                                $currentVar=$currentVar->$attribute;
                                            }


                                            elseif(isset($currentVar->$attribute)) {
                                                $currentVar=$currentVar->$attribute;
                                            }
                                            else {
                                                $currentVar=null;
                                            }
                                        }

                                        if(!is_scalar($currentVar)) {
                                            $valueReference=$currentVar;
                                        }
                                        if($currentVar!==null && (is_string($currentVar) || is_int($currentVar))) {
                                                return $currentVar;
                                        }
                                        else {
                                            return $matches[0];
                                        }
                                    }
                                    if($currentVar) {
                                        if(is_string($returnValue)) {
                                            return $returnValue;
                                        }
                                        else {
                                            return $matches[0];
                                        }

                                    }
                                    else {
                                        return $matches[0];
                                    }


                                }, $parameterValue);


                                if($valueReference) {
                                    $parameterValue=$valueReference;
                                }
                            }

                            $component->setVariable($parameterName, $parameterValue);

                        }
                    }


                    $componentOutput=$component->encapsulateHTML($component->render(), false);
                }


                $this->replaceNodeWithContent($componentNode, $componentOutput);
            }
        }


        //=======================================================s



        $buffer=$this->domDescriptor->saveHTML();




        $mustacheEngine=new \Mustache_Engine();
        //$this->compiledDescriptor=$mustacheEngine->render($this->descriptor, $this->data);
        $this->compiledDescriptor=$mustacheEngine->render($buffer, $this->data);




        $templateReference=$this->getLayoutReference();


        $this->layout=$this->getLayoutByReference($templateReference);
        $this->layout->setDescriptor($this->compiledDescriptor);



        //$buffer=$this->layout->render();
        //$this->template=new \CapitalSite\Frontend\Bridge\DOMTemplate($buffer);

        return $this;
    }


    public function render() {

        $this->compile();
        $buffer=$this->layout->render();



        /*
        if($this->debugMode) {

        }
        */


        return $buffer;

    }









    protected function replaceNodeWithContent($containerNode, $content) {

        $xml='<'.static::XML_VALUE_ROOT_NODE_NAME.'>'.$content.'</'.static::XML_VALUE_ROOT_NODE_NAME.'>';
        $valueDocument=new DOMDocument('1.0', 'utf-8');
        @$valueDocument->loadHTML('<?xml encoding="utf-8" ?>'.$xml, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD);

        $xPath=new DOMXPath($valueDocument);
        $query='//'.static::XML_VALUE_ROOT_NODE_NAME.'/*';
        $valueNodes=$xPath->query($query);


        $this->replaceNodeWithNodes($containerNode, $valueNodes);
    }



    protected function replaceNodeWithNodes($containerNode, $nodes) {


        $nodesArray=array();
        foreach($nodes as $node){
            $nodesArray[] = $node;
        }

        $reversedValues=array();

        //inversion de l'ordre des noeud à injecter (car par là suite on utilse un "insert before")
        $index=0;
        foreach ($nodesArray as $valueNode) {
            $reversedValues[]=$nodesArray[$nodes->length-1-$index];
            $index++;
        }


        //réinjection des noeuds dans le document principal
        $index=0;
        foreach ($reversedValues as $valueNode) {
            $newValueNode=$valueNode->cloneNode(true);

            $importedValueNode=$this->domDescriptor->importNode($newValueNode, true);

            if($index==0) {
                $containerNode->parentNode->replaceChild($importedValueNode, $containerNode);
                $containerNode=$importedValueNode;
            }
            else {
                $containerNode->parentNode->insertBefore($importedValueNode, $containerNode);
                $containerNode=$importedValueNode;
            }

            $index++;
        }
    }


















    public function transformLocalURLToProductionURL($buffer) {
        $buffer=str_replace('="/var/cap/storage', '="http://www.capital.fr/var/cap/storage', $buffer);
        return $buffer;
    }




}