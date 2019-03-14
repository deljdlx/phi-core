<?php

namespace Phi;

if(!defined('PHI_CORE_INITIALIZED')) {

    define('PHI_CORE_INITIALIZED', true);
    require(__DIR__.'/source/class/Autoloader.php');

    $currentPhiPath = realpath(__DIR__.'/..');



    $__PhiAutoloader = \Phi\Core\Autoloader::getInstance();
    $__PhiAutoloader->addNamespace('Phi\Core', __DIR__.'/source/class');

    $__PhiAutoloader->addNamespace('Phi\VirtualFileSystem', $currentPhiPath.'/phi-virtual-filesystem/source/class');



    $__PhiAutoloader->addNamespace('Phi\Traits', $currentPhiPath.'/phi-traits/source/class');



    $__PhiAutoloader->addNamespace('Phi\Storage', $currentPhiPath.'/phi-storage/source/class');


    $__PhiAutoloader->addNamespace('Phi\Event', $currentPhiPath.'/phi-event/source/class');


    $__PhiAutoloader->addNamespace('Phi\HTTP', $currentPhiPath.'/phi-http/source/class');
    $__PhiAutoloader->addNamespace('Phi\Routing', $currentPhiPath.'/phi-routing/source/class');
    $__PhiAutoloader->addNamespace('Phi\Session', $currentPhiPath.'/phi-session/source/class');


    $__PhiAutoloader->addNamespace('Phi\Database', $currentPhiPath.'/phi-database/source/class');
    $__PhiAutoloader->addNamespace('Phi\Model', $currentPhiPath.'/phi-model/source/class');




    $__PhiAutoloader->addNamespace('Phi\Container', $currentPhiPath.'/phi-container/source/class');

    $__PhiAutoloader->addNamespace('Phi\Application', $currentPhiPath.'/phi-application/source/class');




    $__PhiAutoloader->addNamespace('Phi\Cache', $currentPhiPath.'/phi-cache/source/class');

    $__PhiAutoloader->addNamespace('Phi\Template', $currentPhiPath.'/phi-template/source/class');
    $__PhiAutoloader->addNamespace('Phi\HTML', $currentPhiPath.'/phi-html/source/class');
    $__PhiAutoloader->addNamespace('Phi\HTML\Extended', $currentPhiPath.'/phi-html-extended/source/class');



    $__PhiAutoloader->register();

    return $__PhiAutoloader;

}
else {
    throw new \Phi\Core\Exception('Phi bootstrap called twice');
}













