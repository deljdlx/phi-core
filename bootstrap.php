<?php

if(!defined('PHI_INITIALIZED')) {

    //include(__DIR__.'/source/class/Autoloader.php');
	include(__DIR__.'/vendor/autoload.php');

    $helpers=glob(__DIR__.'/source/helper/*.php');

    foreach ($helpers as $helper) {
        include($helper);
    }

    //registerNamespace('Phi', __DIR__.'/source/class');



    define('PHI_INITIALIZED', true);
}













