<?php

namespace Phi\Module\DOMTemplate;


use Phi\DOMDocument;
use Phi\Module\DOMTemplate\Traits\MustacheTemplate;
use Phi\Traits\Collection;

class Template
{



    use Collection;
    use MustacheTemplate;


    protected $output;
    protected  $template;


    protected $dom;
    protected $rootNode;


    protected $customTags=array();

    protected $componentEnabled=false;

    protected $defaultComponentTagName='phi-component';
    protected $componantClassNameAttributeName='data-instanceof';

	protected $components=array();




    public function __construct($template=null) {
        $this->template=$template;
    }

    public function setTemplate($template) {
        $this->template=$template;
        return $this;
    }


    public function registerCustomTag($tagName, $callback) {
        $this->customTags[$tagName]=$callback;
        return $this;
    }

    public function enableComponents($value=true) {
        $this->componentEnabled=$value;
        return $this;
    }



    public function createDomDocumentFromNode(\DOMElement $node) {

        $valueNode=$node->cloneNode(true);

        $valueDocument=new DOMDocument('1.0', 'utf-8');
        $importedValueNode=$valueDocument->importNode($valueNode, true);
        $valueDocument->appendChild($importedValueNode);

        return $valueDocument;

    }



    public function bindVariariablesWithComponents() {

    }





    public function parseDOM($buffer) {

        libxml_use_internal_errors(true);

        $this->dom=new DOMDocument('1.0', 'utf-8');

        $this->dom->loadXML($buffer, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD | \LIBXML_NOXMLDECL);
        $this->rootNode=$this->dom->firstChild;

        if($this->componentEnabled) {
            $this->initializeComponentParsing();
        }


        foreach ($this->customTags as $tagName=>$renderer) {
            $query='//'.$tagName;


            $xPath=new \DOMXPath($this->dom);
            $nodes=$xPath->query($query);


            foreach ($nodes as $node) {
                $content=call_user_func_array($renderer, array($node));
                $this->dom->replaceNodeWithContent($node, $content);
            }
        }

        return $this->dom->saveHTML();
    }


    public function initializeComponentParsing() {


        $this->registerCustomTag($this->defaultComponentTagName, function(\DOMElement $node) {

            $className=(string) $node->getAttribute($this->componantClassNameAttributeName);

            if(class_exists($className)) {

            	//extraction des variables injectées

	            $buffer=$this->dom->getXML($node);

	            echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
	            echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
	            print_r(htmlentities($buffer));
	            echo '</pre>';

	            preg_replace_callback('`\{\{\{(.*?)\}\}\}`', function($matches) {
		            echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
		            echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
		            print_r($matches);
		            echo '</pre>';
	            }, $buffer);

                $component=new $className;
                $component->loadFromDOMNode($node);
                return $component;
            }

            return '';
        });
    }



    public function render($template=null, $values=null) {

        if($template) {
            $this->template=$template;
        }


        if(count($values)) {
            $this->setVariables($values);
        }





        $compiledDom=$this->parseDOM($this->template);

	    $output=$this->compileMustache($compiledDom, $this->getVariables());


        $this->output=$output;
        return $this->output;
    }




    public function getOutput($template=null, $values=null) {
        if($this->output===null) {
            return $this->render($template, $values);
        }
        else {
            return $this->output;
        }
    }

}