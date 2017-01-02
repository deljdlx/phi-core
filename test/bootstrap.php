<?php

ini_set('display_errors', 'on');


require(__DIR__ . '/../bootstrap.php');




spl_autoload_register(function($className) {
    if(stripos($className, 'PhiTestCase')===0) {
        $baseName=baseName(str_replace('\\', '/', $className));
        include(__DIR__.'/test/phi/'.$baseName.'/'.$baseName.'.test.php');
    }
});

