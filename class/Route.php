<?php


namespace Phi;


use Phi\Exception;

class Route
{

    protected $validator;
    protected $callback;
    protected $verbs=array();
    protected $parameters=array();

    protected $headers=array();

    protected $isLast=false;


    protected $builder;


    public function __construct($verbs, $validator, $callback, $headers=array(), $builder=null) {
        $this->validator=$validator;
        $this->callback=$callback;
        $this->verbs=array($verbs);
        $this->headers=$headers;
        $this->builder=$builder;
    }



    public function header($name, $value) {
        $this->headers[$name]=$value;
        return $this;
    }

    public function getHeaders() {
        return $this->headers;
    }



    public function isLast($value=null) {
        if($value!==null) {
            $this->isLast=$value;
        }

        return $this->isLast;
    }



    public function build(/*$parameter*/) {

        if(is_callable($this->builder)) {
            return call_user_func_array(
                $this->builder,
                func_get_args()
            );
        }
        else {
            throw new Exception('Route does not have un builder function');
        }

    }

    public function validate($request=null) {

        if(!$request) {
            $request=new RouterRequest();
        }


        $callString=$request->getURI();
        $method = strtolower($request->getMethod());


        if(is_string($this->validator)) {
            $matches=array();
            if(in_array($method, $this->verbs) && preg_match_all($this->validator, $callString, $matches)) {

                if(!empty($matches)) {
                    array_shift($matches);

                    foreach ($matches as $key=>$match) {
                        $this->parameters[$key]=$match[0];
                    }

                }
                return true;
            }
        }


        return false;
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
                throw new Exception('Method '.$controllerName.'::'.$method.' missing parameter '.$parameter->name);
            }
        }

        return $callParameters;

    }

    public function execute($request=null) {


        if(is_array($this->callback)) {
            $reflector=new \ReflectionMethod($this->callback[0], $this->callback[1]);
        }
        else {
            $reflector=new \ReflectionFunction($this->callback);
        }


        $parameters=$reflector->getParameters();


        $callParameters=array();

        foreach ($parameters as $index=>$parameter) {

            if(isset($this->parameters[$parameter->name])) {
                $callParameters[]=$this->parameters[$parameter->name];
            }
            else if(isset($this->parameters[$index])) {
                $callParameters[]=$this->parameters[$index];
            }
            else if($parameter->isOptional()) {
                $callParameters[]=$parameter->getDefaultValue();
            }
            else {
                throw new Exception('Route callback missing parameter : '.$parameter->name);
            }
        }




        if(is_array($this->callback)) {
            $buffer=call_user_func_array(
                $this->callback,
                $callParameters
            );
            return $buffer;
        }
        else if($this->callback instanceof \Closure) {
            $buffer=call_user_func_array(
                array($this->callback, '__invoke'),
                $callParameters
            );
            return $buffer;
        }

        return false;


    }

    public function getParameters() {
        return $this->parameters;
    }


}
