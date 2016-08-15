<?php

namespace CapitalSite\DOMTemplate\Bridge;


use CapitalSite\Frontend\Component\Error;
use \DOMXPath;
use \DOMDocument;
use CapitalSite\Frontend\Configuration\Bridge as BridgeConfiguration;

class Fragment
{

    const XPATH_PARAMETERS='/meta[@data-parameter]';
    const XML_VALUE_ROOT_NODE_NAME='valuecontainer';

    const XPATH_PHP_COMPONENT='//component[@type="php"]';
    const XPATH_INLINE_COMPONENT='//component[@type="inline"]';

    const COMPONENT_BODY_TAG_NAME='component-body';


    protected $node;
    protected $value;
    protected $components=array();


    public function __construct($node) {

        $this->loadFromDomNode($node);
    }


    public function getComponentFromNode($node) {
        $componentName=$node->getAttribute('name');

        $className=str_replace('.', '\\', $componentName);


        if(class_exists($className)) {
            $component=new $className;
            return $component;
        }
    }

    protected function compileInlineComponents() {
        //extraction des composants
        $xPath=new DOMXPath($this->node->ownerDocument);
        //gestion du cas ou le noeud est le noeud racine du document
        if($this->node ->ownerDocument->firstChild==$this->node) {
            $query=static::XPATH_INLINE_COMPONENT;
        }
        else {
            $query=$this->node->getNodePath().static::XPATH_INLINE_COMPONENT;
        }
        $componentNodes=$xPath->query($query);


        if($componentNodes->length) {

            foreach ($componentNodes as $componentNode) {

                //extraction du body du composant
                $xPath=new DOMXPath($this->node->ownerDocument);
                $bodyNodes=$xPath->query($componentNode->getNodePath().'/'.static::COMPONENT_BODY_TAG_NAME);



                if($bodyNodes->length) {
                    $html=$this->convertNodeToString($bodyNodes->item(0));
                }

                $xPath=new DOMXPath($this->node->ownerDocument);
                $styleNodes=$xPath->query($componentNode->getNodePath().'/style');


                $style='';
                $className='inlineComponent-'.uniqid();
                if($styleNodes->length) {
                    $style=$styleNodes->item(0)->textContent;
                    $style=preg_replace('`^\s*((?:\w|\.)+?)\s*\{\s*$`m', '.'.\CapitalSite\Frontend\getFromConfiguration('componentCSSClassName').'.'.$className.' $1 {', $style);
                }



                $content=preg_replace('`<'.static::COMPONENT_BODY_TAG_NAME.'>(.*?)</'.static::COMPONENT_BODY_TAG_NAME.'>`si',
                    '<div class="'.\CapitalSite\Frontend\getFromConfiguration('componentCSSClassName').' '.$className.'"><style>
                    '.$style.'
                    </style>
                    $1</div>',
                    $html
                );


                $this->replaceNodeWithContent($componentNode, $content);
            }
        }
    }




    protected function convertNodeToString($node) {
        $valueDocument=new DOMDocument();
        $clone=$node->cloneNode(true);
        $importedNode=$valueDocument->importNode($clone, true);
        $valueDocument->appendChild($importedNode);
        $html=$valueDocument->saveHTML();
        return $html;
    }








    protected function compilePHPComponents($injectInlineAsset=false) {

        //extraction des composants
        $xPath=new DOMXPath($this->node->ownerDocument);

        //gestion du cas ou le noeud est le noeud racine du document
        if($this->node ->ownerDocument->firstChild==$this->node) {
            $query=static::XPATH_PHP_COMPONENT;
        }
        else {
            $query=$this->node->getNodePath().static::XPATH_PHP_COMPONENT;
        }

        $componentNodes=$xPath->query($query);

        if($componentNodes->length) {

            foreach ($componentNodes as $componentNode) {
                $component=$this->getComponentFromNode($componentNode);

                $componentOutput='';

                if(!$component || !($component instanceof \CapitalSite\Frontend\Bridge\Component)) {
                    $componentName=$componentNode->getAttribute('name');
                    $component=new Error();
                    $component->set('componentName', $componentName);
                    $componentOutput=$component->encapsulateHTML($component->render(), $injectInlineAsset);
                }
                else {
                    //extraction des paramètres s'il y en a
                    $parametersXpath=new DOMXPath($this->node ->ownerDocument);
                    $query=$componentNode->getNodePath().static::XPATH_PARAMETERS;

                    $parametersNodes=$parametersXpath->query($query);
                    if($parametersNodes->length) {
                        //on extracte les valeurs des paramètres
                        foreach ($parametersNodes as $parameterNode) {
                            $parameterName=(string) $parameterNode->getAttribute('data-parameter');
                            $parameterValue=(string) $parameterNode->getAttribute('data-value');
                            $component->set($parameterName, $parameterValue);
                        }
                    }
                    $componentOutput=$component->encapsulateHTML($component->render(), $injectInlineAsset);
                }

                $this->replaceNodeWithContent($componentNode, $componentOutput);
            }
        }
    }


    protected function replaceNodeWithContent($containerNode, $content) {

        $xml='<'.static::XML_VALUE_ROOT_NODE_NAME.'>'.$content.'</'.static::XML_VALUE_ROOT_NODE_NAME.'>';
        $valueDocument=new DOMDocument();
        @$valueDocument->loadHTML('<?xml encoding="utf-8" ?>'.$xml);

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

            $importedValueNode=$this->node->ownerDocument->importNode($newValueNode, true);

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





    public function loadFromDomNode($node) {

        //attention ne pas oublier que tout fonctionne par références (donc la plupart des traitement se font sur $this->node)
        $this->node=$node;

        $this->compilePHPComponents();
        $this->compileInlineComponents();

        /*
        $newdoc = new DOMDocument();
        $cloned = $this->node->cloneNode(true);
        $newdoc->appendChild($newdoc->importNode($cloned, true));
        $this->value=$newdoc->saveHTML();
        */

    }

    public function getValue() {
        return $this->value;
    }

    public function getNode() {
        return $this->node;
    }

}
