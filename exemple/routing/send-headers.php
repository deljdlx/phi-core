<?php

include(__DIR__ . '/../../bootstrap.php');
ini_set('display_errors', 'on');



$request = new \Phi\Routing\HTTPRequest();
$request->setURI('/home/hello/world');


$router = new \Phi\Routing\Router();

$route = $router->get('', '`.*`', function () {
    $data=array(
        'content-type'=>'application/json'
    );
    echo json_encode($data);
    return true;

})->addHeader('Content-type', 'application/json')
;

$responseCollection = $router->route($request);
$responseCollection->send();




