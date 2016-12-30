<?php
namespace Phi;



/**
 * Class Test
  * @package Phi
 */


class Test extends Object
{

    protected $skipMethods=array(
        'run',
        '__construct',
        'getTestableMethods'
    );

    protected $className;


    protected $results=array();



    public function __construct() {
        $this->className=get_class($this);
    }


    public function getTestableMethods() {

        $reflector=new \ReflectionClass($this);
        $methods=$reflector->getMethods();

        $methodList=array();

        foreach ($methods as $method) {
            if(!in_array($method->name, $this->skipMethods)) {
                if($method->isPublic()) {
                    $methodList[]=$method->name;
                }
            }
        }

        return $methodList;

    }

    public function run() {

        $reflector=new \ReflectionClass($this);
        $methods=$reflector->getMethods();


        foreach ($methods as $method) {
            if(!in_array($method->name, $this->skipMethods)) {
                if($method->isPublic()) {
                    ob_start();
                    $result=$this->{$method->name}();

                    $key=$this->className.'->'.$method->name;

                    $this->results[$key]=array(
                        'status'=>$result,
                        'output'=>ob_get_clean()
                    );
                }
            }
        }


        return $this->results;
    }



}
