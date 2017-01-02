<?php

registerNamespace('Phi\Module\DOMTemplate', __DIR__.'/source/class');


include(__DIR__ . '/vendor/mustache/src/Mustache/Autoloader.php');

$mustacheAutoloader=new Mustache_Autoloader();
$mustacheAutoloader->register(__DIR__.'/vendor/mustache/src');

