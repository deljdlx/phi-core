<?php

namespace Phi;

use Phi\Exception;


/**
 * Class Router
 * @package CapitalSite
 * @param
 */
class Router
{




    protected $subRouters=array();
    protected $subRouterList=array();



    protected $routes=array();
    protected $routesByName=array();



    protected $sendedHeaders=array();
    protected $waitingHeaders=array();





    public function __construct() {
        $this->initialize();
        $this->loadSubRouters($this->subRouterList);
    }

    public function initialize() {

    }


    public function getRequestURI() {
        return $_SERVER['REQUEST_URI'];
    }



    public function addRoute(Route $route, $name='') {
        $this->routes[]=$route;
        $this->routesByName[$name]=$route;
        return $route;
    }


    public function getRouteByName($name) {
        if(isset($this->routesByName[$name])) {
            return $this->routesByName[$name];
        }
        else {


            foreach ($this->subRouters as $subRouter) {
                try {
                    return $subRouter->getRouteByName($name);

                }
                catch(Exception $exception) {

                }
            }
        }
        throw new Exception('Route with name '.$name. ' does not exist');
    }


    public function get($validator, $callback, $headers=array(), $name='', $builder=null) {
        return $this->addRoute(
            new Route('get', $validator, $callback, $headers, $builder),
            $name
        );
    }

    public function post($validator, $callback, $headers = [], $name = '') {
        return $this->addRoute(
            new Route('post', $validator, $callback, $headers),
            $name
        );
    }

    public function createRoute($verbs, $validator, $callback, $headers = [], $name = '') {
        foreach($verbs as $verb) {
            $this->{$verb}($validator, $callback, $headers, $name);
        }
    }

    public function redirect($url, $status='301 Moved Permanently') {
        if($status) {
            header("Status: ".$status);
        }
        header("Location: ".$url);
        return true;
    }



    public function getWaitingHeaders() {
        return $this->waitingHeaders;
    }

    public function getSendedHeaders() {
        return $this->sendedHeaders;
    }


    public function sendHeader($name, $value) {
        header($name.': '.$value);
        $this->sendedHeaders[$name]=$value;
        return $this;
    }






    public function loadSubRouters(array $subRouterList) {

        $this->modulesRouter=$subRouterList;

        $configuration = Application::getInstance();
        foreach($this->modulesRouter as $moduleName) {
            if(!strpos($moduleName, 'Development') || $configuration->isDevelopmentEnvironnement()) {
                $className = '\CapitalSite\Configuration\Router\\' . $moduleName . 'Router';
                if(class_exists($className)) {
                    $this->subRouters[$moduleName]=new $className;
                }
            }
        }
    }


    public function run($request=null, $sendHeaders=true) {

        if(!$request) {
            $request=new RouterRequest();
        }


        foreach ($this->routes as $route) {
            /**
             * @var \Phi\Route $route
             */

            if($route->validate($request)) {

                ob_start();
                $status=$route->execute($request);
                $content=ob_get_clean();

                if($status) {
                    if($sendHeaders) {
                        $headers=$route->getHeaders();
                        foreach ($headers as $name => $value) {
                            $this->sendHeader($name, $value);
                        }
                    }
                    else {
                        $this->waitingHeaders=$route->getHeaders();
                    }

                    echo $content;
                    return true;
                }
                if($route->isLast()) {
                    break;
                }
            }
        }



        foreach ($this->subRouters as $router) {
            $returnValue=$router->run($request, $sendHeaders);
            if($returnValue) {
                return $returnValue;
            }
        }
        return false;

    }

    public function ob_run($request=null) {
        if(!$request) {
            $request=new RouterRequest();
        }

        ob_start();
        $this->run($request, false);
        return (string) ob_get_clean();
    }



    public function getBindedParametersWithMethod($userParameters, $controllerName, $method) {
        $reflector=new \ReflectionMethod($controllerName, $method);
        $parameters=$reflector->getParameters();


        $callParameters=array();

        foreach ($parameters as $parameter) {

            if(isset($userParameters[$parameter->name])) {
                $callParameters[]=$userParameters[$parameter->name];
            }
            else if($parameter->isOptional()) {
                $callParameters[]=$parameter->getDefaultValue();
            }
            else {

                if(is_object($controllerName)) {
                    $controllerName=get_class($controllerName);
                }

                throw new Exception('Method '.$controllerName.'::'.$method.' missing parameter "'.$parameter->name.'"');
            }
        }

        return $callParameters;

    }


}





