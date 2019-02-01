<?php

include(__DIR__ . '/../../bootstrap.php');
ini_set('display_errors', 'on');




class Foo implements \Phi\Event\Interfaces\Listenable
{
    use \Phi\Event\Traits\Listenable;
}



$test=new Foo();

$test2=new Foo();

$test2->addEventListener('hello', function($event) {
    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
    print_r($event->getData());
    echo '</pre>';
    echo 'hello world';
});


$test->addParentListenable($test2);

$test->fireEvent('hello',  array('foo'=>'world'));

