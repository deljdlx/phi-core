<?php

namespace Phi\Module\DOMTemplate;

use \DOMXPath;
use \DOMDocument;
use Phi\Module\DOMTemplate\Traits\MustacheTemplate;
use Phi\Traits\Collection;


class DOMTemplate extends Fragment
{


    use Collection;
    use MustacheTemplate;

    protected $template;
    protected $domTemplate;
    protected $placeholders;


    protected $values;
    protected $injectInlineAsset=false;


    protected $skipPlaceholderContainer=true;





    public function __construct($template) {
        libxml_use_internal_errors(true);
        $this->template=$template;

        $this->domTemplate=new DOMDocument('1.0', 'utf-8');
        @$this->domTemplate->loadHTML($this->template, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD);
        $this->node=$this->domTemplate->firstChild;
    }

    public function skipPlaceholderContainer($value=null) {
        if($value===null) {
            return $this->skipPlaceholderContainer;
        }
        else {
            $this->skipPlaceholderContainer=$value;
        }

        return $this;
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


                    if($this->skipPlaceholderContainer) {
                        $buffer='';
                        foreach ($importedValueNode->childNodes as $childNode) {
                            $cloned = $childNode->cloneNode(TRUE);
                            $valueDocument=new DOMDocument('1.0', 'utf-8');
                            //$valueDocument->importNode($cloned, true);
                            $valueDocument->appendChild($valueDocument->importNode($cloned,TRUE));
                            $buffer.=$valueDocument->saveHTML();

                        }
                        $this->replaceNodeWithContent($placeholder->getNode(), $buffer);

                    }
                    else {
                        $this->domTemplate->appendChild($importedValueNode);
                        $placeholder->getNode()->parentNode->replaceChild($importedValueNode, $placeholder->getNode());
                    }




                    //die('EXIT '.__FILE__.'@'.__LINE__);
                    //$xPath=new DOMXPath($valueDocument);
                    //$query='//'.static::XML_VALUE_ROOT_NODE_NAME.'/*';
                    //$valueNodes=$xPath->query($query);
                    //$this->replaceNodeWithNodes($containerNode, $valueNodes);
                    //$importedValueNode



                    //$this->replaceNodeWithContent($placeholder->getNode()->parentNode, );
                }
            }
        }


        $this->compilePHPComponents($this->injectInlineAsset);
        $this->compileInlineComponents();


        $buffer=$this->domTemplate->saveHTML();


        return  $this->compileMustache($buffer, $this->getVariables());

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
            $dataDom=new \DOMDocument('1.0', 'utf-8');
            $dataDom->loadHTML('<?xml encoding="utf-8" ?>'.$dataTemplate, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD);


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