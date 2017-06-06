<?php



include(__DIR__.'/../bootstrap.php');
ini_set('display_errors', 'on');





$request=new \Phi\Routing\Request();
$request->setURI('/home/hello/world');


$router=new \Phi\Routing\Router();




$route=$router->get('test-02', '`hello/(.*?)$`', function($string) {
    echo 'Catched "'.$string, '"', "\n";
    return true;
})->setBuilder('/hello/{string}');


$route=$router->get('test-00', '`hello'.$router->getEndRouteRegexp().'`', function() {
	echo "hello route\n";
	return true;
});


$route=$router->get('test-01', '`.*`', function() {
	echo "match all route\n";
	return true;
});

$router->route($request);

echo "\n\n";

echo $router->build('test-02', array(
    'string'=>'yolo'
));


