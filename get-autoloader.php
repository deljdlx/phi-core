<?php

namespace Phi;

if(!defined('PHI_CORE_INITIALIZED')) {

    define('PHI_CORE_INITIALIZED', true);
    require(__DIR__.'/source/class/Autoloader.php');



    $__PhiAutoloader=new \Phi\Core\Autoloader();
    $__PhiAutoloader->addNamespace('Phi\Core', __DIR__.'/source/class');
    $__PhiAutoloader->register();

    return $__PhiAutoloader;

}
else {

    return $__PhiAutoloader;

    //throw new \Phi\Core\Exception('Phi bootstrap called twice');
}













