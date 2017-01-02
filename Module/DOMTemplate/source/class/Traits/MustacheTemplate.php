<?php

namespace Phi\Module\DOMTemplate\Traits;


Trait MustacheTemplate
{





    public function compileMustache($buffer, $variables) {
        $mustacheEngine=new \Mustache_Engine();
        $compiled=$mustacheEngine->render($buffer, $variables);

        return $compiled;
    }

}
