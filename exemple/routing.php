<?php


include(__DIR__ . '/../bootstrap.php');
ini_set('display_errors', 'on');


//throw new Exception('test');

$request = new \Phi\Routing\HTTPRequest();

//$request=new \Phi\HTTP\Request();
$request->setURI('/home/hello/world');


$router = new \Phi\Routing\Router();


$route = $router->get('test-02', '`hello/(.*?)$`', function ($string) {
    $data=array(
       'catched'=>$string
    );

    echo json_encode($data);
    return true;

})->setBuilder('/hello/{string}')
->addHeader('Content-type', 'application/json')
;


$route = $router->get('test-00', '`hello' . $router->getEndRouteRegexp() . '`', function () {
    echo "hello route\n";
    return true;
});


$route = $router->get('test-01', '`.*`', function () {
    echo "match all route\n";
    return true;
});



$responseCollection = $router->route($request);

$responseCollection->send();


