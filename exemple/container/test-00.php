<?php
ini_set('display_errors', 'on');
require(__DIR__.'/../../bootstrap.php');


$container=new \Phi\Container\Container();


$container->set('test', function() {
    return 'hello world';
});

echo $container->get('test');

echo '<hr/>';


class Test
{
    public $value;
    public function __construct($value) {
        $this->value=$value;
    }
}

$container->set('test2', new Test('hello'));

echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($container->get('test2'));
echo '</pre>';


echo '<hr/>';


$container->set('test2', function() {
    return new Test(uniqid());
});

echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($container->get('test2'));
echo '</pre>';


echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($container->get('test2'));
echo '</pre>';

echo '<hr/>';


$container->set('test2', function() {
    return new Test(uniqid());
}, false);

echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($container->get('test2'));
echo '</pre>';


echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($container->get('test2'));
echo '</pre>';
