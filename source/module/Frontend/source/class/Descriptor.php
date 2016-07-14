<?php

namespace CapitalSite\Frontend\Bridge;

use \DOMXPath;
use \DOMDocument;
use Premium\Exception;
use Premium\Traits\Introspectable;


use CapitalSite\Frontend\Configuration\Bridge as BridgeConfiguration;



class Descriptor
{

    use Introspectable;

    const XPATH_TEMPLATE='//metadata/link[@rel="CapitalSite/Template"]';
    const XPATH_DATASOURCE='//metadata/link[@rel="CapitalSite/DataSource"]';
    const XPATH_DATANODE='//metadata/script[@type="data/json"]';


    protected $descriptor='';
    protected $compiledDescriptor='';

    protected $domDescriptor;
    protected $template;

    protected $dataSource;
    protected $data=array();



    public function __construct($descriptor=null) {
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

    public function loadDataSource($url, $variableName) {
        $json=file_get_contents($url);
        $this->data[$variableName]=json_decode($json);
    }


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
        $className='\CapitalSite\Frontend\Layout\\'.$componentName;

        if(class_exists($className)) {
            $layout=new $className();
            $layout->loadTemplate($componentTemplate.'.php');

            return $layout;
        }
        else {
            throw new Exception('Can not load template "'.$reference.'"');
        }
    }

    public function compile() {

        $this->domDescriptor=new DOMDocument('utf-8');
        @$this->domDescriptor->loadHTML('<?xml encoding="utf-8" ?>'.$this->descriptor);


        //chargement des data========================================
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

        //=====================================================


        $mustacheEngine=new \Mustache_Engine();
        $this->compiledDescriptor=$mustacheEngine->render($this->descriptor, $this->data);

        $templateReference=$this->getLayoutReference();


        $this->layout=$this->getLayoutByReference($templateReference);
        $buffer=$this->layout->encapsulateHTML($this->layout->render());


        $this->template=new \CapitalSite\Frontend\Bridge\DOMTemplate($buffer);
        return $this;
    }


    public function render() {

        $this->compile();
        $buffer=$this->template->compile($this->compiledDescriptor);
        return $buffer;

    }

    public function transformLocalURLToProductionURL($buffer) {
        $buffer=str_replace('="/var/cap/storage', '="http://www.capital.fr/var/cap/storage', $buffer);
        return $buffer;
    }




}