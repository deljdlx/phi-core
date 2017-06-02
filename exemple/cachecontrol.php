<?php


include(__DIR__.'/../bootstrap.php');
ini_set('display_errors', 'on');



$cache=new \Phi\HTTP\CacheControl(120);

$cache->sendHeaders();

echo microtime();

