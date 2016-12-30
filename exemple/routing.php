<?php



include(__DIR__.'/../bootstrap.php');
ini_set('display_errors', 'on');





$router=new \Phi\Routing\Router();
$router->get('`hello'.$router->getEndRouteRegexp().'`', function() {
	echo "hello route\n";
	return true;
});


$router->get('`.*`', function() {
	echo "match all route\n";
	return true;
});

$router->run();


