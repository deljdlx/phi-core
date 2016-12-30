<?php

namespace Phi;



class DOMDocument extends \DOMDocument
{


    const XML_VALUE_ROOT_NODE_NAME='phi-dom-tempnode-root';

    public function replaceNodeWithContent($containerNode, $content) {


        /*
        $xml='<'.static::XML_VALUE_ROOT_NODE_NAME.'>'.$content.'</'.static::XML_VALUE_ROOT_NODE_NAME.'>';
        $valueDocument=new \DOMDocument('1.0', 'utf-8');
        $valueDocument->loadHTML('<?xml encoding="utf-8" ?>'.$xml, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD);
        $xPath=new \DOMXPath($valueDocument);
        $query='//'.static::XML_VALUE_ROOT_NODE_NAME.'/*';
        $valueNodes=$xPath->query($query);
        */

        $contentNode=$this->createCDATASection($content);
        $this->replaceNodeWithNode($containerNode, $contentNode);

        return $contentNode;
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


            $importedValueNode=$this->importNode($newValueNode, true);

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


    protected function replaceNodeWithNode($containerNode, $node) {
        $newValueNode=$node->cloneNode(true);
        $importedValueNode=$this->importNode($newValueNode, true);
        $containerNode->parentNode->replaceChild($importedValueNode, $containerNode);
    }

    public function getXML($node=null) {
        if(!$node) {
            return $this->saveXML($this->firstChild);
        }
        else {
            return $this->saveXML($node);
        }
    }


    /*
    public function convertNodeToString($node) {
        $valueDocument=new DOMDocument('1.0', 'utf-8');
        $clone=$node->cloneNode(true);
        $importedNode=$valueDocument->importNode($clone, true);
        $valueDocument->appendChild($importedNode);
        $html=$valueDocument->saveHTML();
        return $html;
    }
    */


}