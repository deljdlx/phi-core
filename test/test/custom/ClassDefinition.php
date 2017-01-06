<?php

class Test
{
    public function __construct() {

}

    public function hello() {
    echo 'hello world';
    }
}

class ClassDefinition
{

    protected $extend=null;
    protected $methods=array();

    public function extend($className) {
        $this->extend=$className;
    }

    public function getInstance() {

        $extend='';
        if($this->extend) {
            $extend=' extends '.$this->extend.' ';
        }

        $methodString='';

        ini_set('display_errors', 'on');

        foreach ($this->methods as $name => $descriptor) {

            $callback=$descriptor['callback'];
            $reflector=new ReflectionFunction($callback);
            $parameters=$reflector->getParameters();

            $parameterString='';
            foreach ($parameters as $parameter) {
                $parameterString.='$'.$parameter->name;


                // && $parameter->getDefaultValue()
                if($parameter->isOptional()) {

                    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
                    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
                    print_r($parameter->export($callback, $parameter->name, true));
                    echo '</pre>';

                    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
                    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
                    print_r($parameter->name);
                    echo '</pre>';


                    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
                    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
                    print_r($parameter->isArray());
                    echo '</pre>';


                    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
                    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
                    print_r($parameter->getDefaultValueConstantName());
                    echo '</pre>';


                    $defaultValue=$parameter->getDefaultValue();

                    echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
                    echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
                    print_r($defaultValue);
                    echo '</pre>';

                    if(is_string($defaultValue)) {
                        $parameterString.='='."'".$defaultValue."'";
                    }
                    else if(is_array($defaultValue)) {
                        $parameterString.='=array()';
                    }
                    else {
                        $parameterString.='='.$defaultValue;
                    }


                }

                $parameterString.=',';
            }
            if($parameterString) {
                $parameterString=substr($parameterString, 0, -1);
            }



            $methodString.='    '.$descriptor['visibility'].' function '.$name.' ('.$parameterString.') {

            }
            ';
        }


        $code='
            $instance=new Class '.$extend.'{
                '.$methodString.'
            };
        ';
        echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
        echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
        print_r($code);
        echo '</pre>';

        eval($code);
        return $instance;

    }

    public function addMethod($name, $callback, $visibility='public') {

        $this->methods[$name]=array(
            'callback'=>$callback,
            'visibility'=>$visibility,
        );
        return $this;

    }

}


$class=new ClassDefinition();
$class->extend('Test');
$class->addMethod('yolo', function(string $string='hello world', $test=array('toto')) {
    return $string;
});


$instance=$class->getInstance();