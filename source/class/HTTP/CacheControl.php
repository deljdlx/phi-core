<?php


namespace Phi\HTTP;




class CacheControl
{

    protected $maxAge=600;
    protected $public=true;
    protected $noStore=false;
    protected $noCache=false;

    public function __construct($maxAge=600) {
        $this->maxAge=$maxAge;
    }

    public function noStore($value=null) {
        if($value===null) {
            return $this->noStore;
        }
        else {
            $this->noStore=$value;
            return $this;
        }
    }


    public function noCache($value=null) {
        if($value===null) {
            return $this->noCache;
        }
        else {
            $this->noCache=$value;
            return $this;
        }
    }



    public function getHeaders() {

        $name="Cache-Control";
        $headers=array();

        if(!$this->noStore) {

            if($this->public) {
                $value='public';
            }
            else {
                $value='private';
            }

            $value.=', max-age='.(int) $this->maxAge;

            $expire=gmdate('D, d M Y H:i:s', time()+$this->maxAge).' GMT';
            $headers[]=array(
                'name'=>'Expires',
                'value'=>$expire
            );

            if($this->noCache) {
                $value.=', no-cache';
            }
        }
        else {
            $value='no-store';
        }

        $headers[]=array(
            'name'=>$name,
            'value'=>$value
        );
        return $headers;
    }

    public function sendHeaders() {
        $headers=$this->getHeaders();
        foreach ($headers as $header) {
            header($header['name'].': '.$header['value']);
        }
    }




}