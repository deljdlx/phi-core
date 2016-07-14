<?php
namespace Phi;


class Request implements \Phi\Interfaces\Request
{



	protected static $mainInstance=null;

	protected $uri=null;


	public static function getInstance() {

		if(static::$mainInstance===null) {
			static::$mainInstance=new static();
		}
		return static::$mainInstance;
	}


	public function __construct() {
		if($this->isHTTP()) {
			$this->URI=$_SERVER['REQUEST_URI'];
		}
	}

	public function getURI() {
		return $this->URI;
	}


	public function isHTTP() {


		if(php_sapi_name() == "cli") {
			return false;
		}
		else {
			return true;
		}
	}






}