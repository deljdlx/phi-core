<?php

namespace Phi\Module\DOMTemplate;


class Placeholder
{

    protected $selector;
    protected $node;

    public function __construct($node) {
        $this->node=$node;
        $this->selector=$node->getAttribute('select');
    }


    public function getSelector() {
        return $this->selector;
    }

    public function getNode() {
        return $this->node;
    }
}


