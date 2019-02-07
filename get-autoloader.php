<?php

namespace Phi;

if(!defined('PHI_CORE_INITIALIZED')) {

    define('PHI_CORE_INITIALIZED', true);
    require(__DIR__.'/source/class/Autoloader.php');

    $autoloader=new \Phi\Core\Autoloader();
    $autoloader->addNamespace('Phi\Core', __DIR__.'/source/class');
    $autoloader->register();


    //function getPath



    return $autoloader;

}
else {
    throw new \Phi\Core\Exception('Phi bootstrap called twice');
}













