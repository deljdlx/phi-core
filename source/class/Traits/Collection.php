<?php
namespace Phi\Traits;

use CapitalSite\Configuration\Application;
use Premium\Cache\Blackhole;
use Premium\Interfaces\CacheDriver;


/*
 *
 * @var \Premium\Interfaces\CacheDriver $cacheDriver
 */

Trait Collection
{


	protected $variableCollection=array();





	public function setVariable($name, $value) {
		$this->variableCollection[$name]=$value;
		return $this;
	}


	public function &getVariable($name) {
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