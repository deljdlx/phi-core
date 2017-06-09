<?php

include(__DIR__ . '/../../bootstrap.php');
ini_set('display_errors', 'on');



class Test
{

    public function test($hello, $world) {
        return $hello.' '.$world;
    }

}



$router = new \Phi\Routing\Router();

$route = $router->get('catch-all', '`/(.*?)/(.*?)`', function ($hello, $world) {



    $binder=new \Phi\Routing\Binder($this);
    echo $binder->run(array('Test', 'test'));




    /*
    $parameters=$binder->getMethodParameters(array($hello, $world), 'Test', 'test');
    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
    print_r($parameters);
    echo '</pre>';
    */

    return true;
})
;

$responseCollection = $router->route();
$responseCollection->send();



