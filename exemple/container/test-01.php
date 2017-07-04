<?php

ini_set('display_errors', 'on');
require(__DIR__.'/../../bootstrap.php');



class Test
{
    use \Phi\Container\Traits\Depends;

    protected $dependencies=array(
        'test'=>null
    );

    public function hello() {
        return $this->getDependency('test')->hello();
    }
}

class Injected
{
    public function hello() {
        return 'hello world';
    }
}


$container=new \Phi\Container\Container();
$container->set('test', function() {
    return new Injected();
});



$test=new Test();
$test->resolveDependencies($container);
echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($test->hello());
echo '</pre>';

