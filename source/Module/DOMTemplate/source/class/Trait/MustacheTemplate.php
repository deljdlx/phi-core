<?php

namespace Phi\Module\DOMTemplate\Traits;


Trait MustacheTemplate
{




    public function render($template, $variables=array()) {
        $mustacheEngine=new \Mustache_Engine();
        $compiled=$mustacheEngine->render($template, $variables);

        return $compiled;
    }



}
