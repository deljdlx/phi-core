<?php

include(__DIR__ . '/../../bootstrap.php');
ini_set('display_errors', 'on');



$request = new \Phi\Routing\HTTPRequest();
$request->setURI('/home/hello/world');


$router = new \Phi\Routing\Router();


$route = $router->get('catch-all', '`.*$`', function () {
    echo 'Request catched by route "'.$this->getName().'"';
    return true;

});

$route->addEventListener(\Phi\Routing\Event\Match::class, function() {
    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
    print_r('Event Match catched');
    echo '</pre>';
});


echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($route);
echo '</pre>';


$responseCollection = $router->route($request);

$responseCollection->send();




