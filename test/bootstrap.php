<?php



require(__DIR__ . '/../bootstrap.php');
registerNamespace('PhiTest', __DIR__.'/source');



spl_autoload_register(function($className) {
    if(stripos($className, 'PhiTestCase')===0) {
        $baseName=baseName(str_replace('\\', '/', $className));
        include(__DIR__.'/test/phi/'.$baseName.'/'.$baseName.'.test.php');
    }
});
