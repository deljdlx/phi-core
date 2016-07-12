<?php
namespace Phi;


class Request
{



	protected static $mainInstance=null;


	public static function getInstance() {

		if(static::$mainInstance===null) {
			static::$mainInstance=new static();
		}
		return static::$mainInstance;
	}


	public function __construct() {

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