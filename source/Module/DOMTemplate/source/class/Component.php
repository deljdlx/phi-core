<?php

namespace Phi\Module\DOMTemplate;



use Phi\Module\DOMTemplate\Traits\MustacheTemplate;
use Phi\Traits\Collection;

class Component extends Template
{


    protected $attributeXPathQuery='//meta[@data-attribute-name]';
    protected $attributeAttributeName='data-attribute-name';


    public function __construct($template=null) {
        parent::__construct($template);
    }

    public function loadFromDOMNode(\DOMElement $node) {


        $this->dom=$this->createDomDocumentFromNode($node);
        $this->extractParametersFromDOM($this->dom);
        return $this;
    }

    public function extractParametersFromDOM($dom) {

        $query=$this->attributeXPathQuery;

        $xPath=new \DOMXPath($dom);
        $nodes=$xPath->query($query);

        foreach ($nodes as $attributeNode) {
            /**
             * @var \DOMElement $attributeNode
             */

            $attributeName=(string) $attributeNode->getAttribute($this->attributeAttributeName);
            $this->setVariable($attributeName, $attributeNode->textContent);
        }


    }




    public function __toString() {
        return $this->getOutput();
    }


}