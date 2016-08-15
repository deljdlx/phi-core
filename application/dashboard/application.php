<?php




include(__DIR__.'/bootstrap.php');

//includePhiModule('Frontend');

ini_set('display_errors', 'on');


registerNamespace('Bienvenue', __DIR__.'/source');




$application=new \Phi\Application(__DIR__.'/source');

$router=new \Bienvenue\Configuration\Router();

$application->setRouter($router);
$application->run(true);


//$router->run();


