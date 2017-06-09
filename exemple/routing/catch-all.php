<?php

include(__DIR__ . '/../../bootstrap.php');
ini_set('display_errors', 'on');



$request = new \Phi\Routing\HTTPRequest();
$request->setURI('/home/hello/world');


$router = new \Phi\Routing\Router();


$route = $router->get('catch-all', '`.*$`', function () {
    echo 'Request catched by route "'.$this->getName().'"';
    return true;

})
;

$responseCollection = $router->route($request);

$responseCollection->send();




