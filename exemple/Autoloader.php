<?php


require(__DIR__.'/__bootstrap.php');

$autoloader = new \Phi\Core\Autoloader();
$autoloader->addNamespace('TestPhi', __DIR__.'/asset/TestPhi');
$autoloader->register();

$instance = new \TestPhi\Test();

echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r(get_class($instance));
echo '</pre>';

