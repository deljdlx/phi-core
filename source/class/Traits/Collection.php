<?php
namespace Phi\Traits;


use Phi\Cache\Blackhole;
use Phi\Interfaces\CacheDriver;


Trait Collection
{


	protected $variableCollection=array();




z
	public function setVariable($name, $value) {
		$this->variableCollection[$name]=$value;
		return $this;
	}


	public function getVariable($name) {
		if(isset($this->variableCollection[$name])) {
			return $this->variableCollection[$name];
		}
		else {
			return null;
		}
	}


	public function getVariables() {
		return $this->variableCollection;
	}


	public function setVariables(array $values) {
		foreach ($values as $name=>$value) {
			$this->setVariable($name, $value);
		}

		return $this;
	}





}