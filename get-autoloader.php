<?php

namespace Phi;

if(!defined('PHI_CORE_INITIALIZED')) {

    define('PHI_CORE_INITIALIZED', true);
    require(__DIR__.'/source/class/Autoloader.php');

    $PhiAutoloader=new \Phi\Core\Autoloader();
    $PhiAutoloader->addNamespace('Phi\Core', __DIR__.'/source/class');
    $PhiAutoloader->register();

    return $PhiAutoloader;

}
else {

    return $PhiAutoloader;

    //throw new \Phi\Core\Exception('Phi bootstrap called twice');
}













