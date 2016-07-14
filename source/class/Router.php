<?php

namespace Phi;
use Phi\HTTP\Header;
use Phi\Interfaces\Request;


/**
 * Class Router
 * @package Phi
 * @param
 */
class Router
{


    protected $routes=array();
    protected $headers=array();


    public function addRoute(Route $route, $name) {
        $this->routes[$name]=$route;
        return $route;
    }


    public function getRouteByName($name) {
        if(isset($this->routes[$name])) {
            return $this->routes[$name];
        }
        else {
            throw new Exception('Route with name "'.$name.'" does not exist');
        }
    }


    public function get($validator, $callback, $name=null, $headers=array()) {
        if($name===null) {
            $name=$validator;
        }

        return $this->addRoute(
            new Route('get', $validator, $callback, $headers),
            $name
        );
    }


    protected function getDefaultRequest() {
        return new \Phi\Request();
    }

    public function run(Request $request=null) {

        if($request==null) {
            $request=$this->getDefaultRequest();
        }


        ob_start();
        foreach ($this->routes as $route) {
            /**
             * @var \Phi\Route $route
             */

            if($route->validate($request)) {
                if($route->execute()) {
                    $headers=$route->getHeaders();
                    foreach ($headers as $name=>$value) {
                        $this->headers[$name]=new Header($name, $value);
                    }
                    break;
                }
            }
        }
        $buffer=ob_get_clean();
        if($request->isHTTP()) {
            $this->sendHeaders();
        }
        echo $buffer;
    }


    public function sendHeaders() {
        foreach ($this->headers as $header) {
            $header->send();
        }
        return $this;

    }
}





