<?php


namespace Phi\HTTP;




class Header
{

	protected $name;
	protected $value;


	public function __construct($name, $value) {
		$this->name=$name;
		$this->value=$value;
	}


	public function send() {
		header($this->name.': '.$this->value);
		return $this;
	}




}