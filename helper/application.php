<?php

/*
function registerNamespace($namespace, $folder) {
    static $autoloader;
    if(!$autoloader) {
        $autoloader=new \Premium\Autoloader();
        spl_autoload_register(function($calledClassName) use ($autoloader) {
            $autoloader->autoload($calledClassName);
        });
    }
    $autoloader->addNamespace($namespace, $folder);
}

*/


function is_closure($variable) {
	return is_object($variable) && ($variable instanceof Closure);
}

