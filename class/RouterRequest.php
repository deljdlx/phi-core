<?php


namespace Phi;


class RouterRequest
{

    public function __construct($parameters=null) {

        if($parameters===null) {
            $parameters=$_SERVER;
        }


        foreach ($parameters as $key=>$value) {
            $this->$key=$value;
        }

    }



    public function getURI() {
        return $this->REQUEST_URI;
    }

    public function getMethod() {
        return $this->REQUEST_METHOD;
    }


}