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





	public function set($name, $value) {
		$this->variableCollection[$name]=$value;
		return $this;
	}


	public function &get($name) {
		if(isset($this->variableCollection[$name])) {
			return $this->variableCollection[$name];
		}
		else {
			return null;
		}
	}


	public function getVariableCollection() {
		return $this->variableCollection;
	}





}