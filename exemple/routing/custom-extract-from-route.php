<?php

include(__DIR__ . '/../../bootstrap.php');
ini_set('display_errors', 'on');



$router = new \Phi\Routing\Router();

$route = $router->get('catch-all', '`/(.*?)/`', function ($hello, $world, $name='John Doe') {
    echo 'Return value "'.$hello.' | '.$world.' | '.$name.'"';
    return true;
})->setParameterExtractor(function($request) {
    return explode('/', $request->getURI());
})
;

$responseCollection = $router->route();
$responseCollection->send();




