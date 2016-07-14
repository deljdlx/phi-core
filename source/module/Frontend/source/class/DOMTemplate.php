<?php

namespace Phi\Module\Frontend;

use \DOMXPath;
use \Phi\DOMDocument;
use Phi\PHPTemplate;




class DOMTemplate extends PHPTemplate
{


    const PLACEHOLDER_XPATH='//content';
    const XML_VALUE_ROOT_NODE_NAME="placeholderValue";


    protected $dom;
    protected $placeholders=array();



    protected function replaceNodeWithContent($containerNode, $content) {

        $xml='<'.static::XML_VALUE_ROOT_NODE_NAME.'>'.$content.'</'.static::XML_VALUE_ROOT_NODE_NAME.'>';
        $valueDocument=new DOMDocument();
        $valueDocument->loadXML('<?xml version="1.0" encoding="utf-8" ?>'.$xml);

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

            $importedValueNode=$containerNode->ownerDocument->importNode($newValueNode, true);

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





    public function extractPlaceholders() {
        $xPath=new DOMXPath($this->dom);
        $nodes=$xPath->query(static::PLACEHOLDER_XPATH);

        foreach ($nodes as $node) {
            $name=$node->getAttribute('name');
            $placeholder=new DOMPlaceholder($node);
            $this->placeholders[]=$placeholder;
        }

        return $this;

    }





    public function buildDOM($buffer) {
        $this->dom=new DOMDocument('utf-8');
        $this->dom->loadXML('<?xml version="1.0" encoding="utf-8" ?>'.$buffer.'');
        return $this;
    }




    public function render($template=null, $variables=null) {

        $output=parent::render($template, $variables);

        if(!$output) {
            $output=$template;
        }

        if(!$this->dom) {
            $this->buildDOM($output);
        }

        $this->extractPlaceholders();

        $this->replaceNodeWithContent($this->placeholders[0]->getNode(), '<span>hello world</span>');

        return $this->dom->saveHTML();
    }



}



/*
class DOMTemplate extends Fragment
{


    use Collection;

    protected $template;
    protected $domTemplate;
    protected $placeholders;


    protected $values;
    protected $injectInlineAsset=false;





    public function __construct($template) {
        $this->template=$template;

        $this->domTemplate=new DOMDocument('utf-8');
        @$this->domTemplate->loadHTML($this->template);
        $this->node=$this->domTemplate->firstChild;
    }


    public function compile($dataTemplate=null) {
        $this->extractPlaceholders();
        if($dataTemplate) {
            $this->extractContent($dataTemplate, $this->placeholders);
        }



        if(count($this->placeholders)) {
            foreach ($this->placeholders as $name=>$placeholder) {

                if(isset($this->values[$name])) {

                    $valueNode=$this->values[$name]->getNode()->cloneNode(true);
                    $importedValueNode=$this->domTemplate->importNode($valueNode, true);
                    $this->domTemplate->appendChild($importedValueNode);


                    $placeholder->getNode()->parentNode->replaceChild($importedValueNode, $placeholder->getNode());
                }
            }
        }


        $this->compilePHPComponents($this->injectInlineAsset);
        $this->compileInlineComponents();


        $buffer=$this->domTemplate->saveHTML();


        $mustacheEngine=new \Mustache_Engine();


        $compiled=$mustacheEngine->render($buffer, $this->getVariableCollection());

        return $compiled;
    }


    public function injectInlineAsset($value=null) {
        if($value===null) {
            return $this->injectInlineAsset;
        }
        else {
            $this->injectInlineAsset=$value;
        }
        return $this;
    }



    public function extractPlaceholders() {
        $xPath=new DOMXPath($this->domTemplate);
        $nodes=$xPath->query('//content');

        foreach ($nodes as $node) {
            $name=$node->getAttribute('name');
            $placeholder=new Placeholder($node);
            $this->placeholders[$name]=$placeholder;
        }
    }

    public function extractContent($dataTemplate=null, $placeholders=array()) {

        if($dataTemplate) {
            $dataDom=new \DOMDocument('utf-8');
            @$dataDom->loadHTML('<?xml encoding="utf-8" ?>'.$dataTemplate);


            $values=array();
            foreach ($placeholders as $name => $placeholder) {

                $selector=str_replace('.', '', trim($placeholder->getSelector()));


                $xPath=new DOMXPath($dataDom);
                $query='//*[@class="'.$selector.'"]';
                $nodes=$xPath->query($query);


                if($nodes->length) {

                    $node=$nodes->item(0);
                    $value=new Fragment($node);

                    $values[$name]=$value;
                }
            }
            $this->values=$values;
        }
    }
}

*/