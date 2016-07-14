<?php


namespace Phi;




use CapitalSite\Cache\File;
use Premium\Cache\Blackhole;
use Premium\Traits\Cachable;

class PHPTemplate
{


	use Cachable;


	protected $values=array();
	protected $template=null;
	protected $components=array();



	public function __construct($template=null) {
		$this->template=$template;
	}





	public function set($name, $value) {



		$this->values[$name]=$value;
		return $this;
	}

	public function __set($name, $value) {
		return $this->set($name, $value);
	}



	/*
	public function add($name, $value) {
		if(!isset($this->values[$name])) {
			$this->values[$name]=new PHPTemplateValue($value);
		}

		$this->values[$name]->add($value);
		return $this;
	}
	*/

	public function setValues(array $values) {
		foreach ($values as $name=>$value) {
			$this->set($name, $value);
		}

		return $this;
	}

	public function &get($name) {
		if(isset($this->values[$name])) {

			return $this->values[$name];

			return $this->values[$name]->getValue();
		}
		else {
			return null;
		}
	}

	public function &__get($name) {
		return $this->get($name);
	}




	public function display($name) {



		if(isset($this->values[$name])) {

			if(is_array($this->values[$name])) {
				foreach ($this->values[$name] as $value) {
					echo $value;
				}
			}
			else {
				echo $this->values[$name];
			}

		}
		else {
			echo '';
		}
	}


	public function registerComponent($component) {
		$this->components[]= $component;
		$this->components=array_merge($this->components, $component->getComponents());
		return $component;
	}

	public function getComponents() {
		return $this->components;
	}


	public function render($template=null) {


		if($template!==null) {
			$this->template=$template;
		}


		if($this->cacheEnable) {
			$exists=$this->existsInCache($this->template, 'template');
			if($exists) {
				return $this->getFromCache($this->template, 'template');
			}
		}


		if(is_file($this->template)) {
			ob_start();
			extract($this->values);
			include($template);
			$buffer=ob_get_clean();

			if($this->cacheEnable) {
				$this->saveInCache($this->template, $buffer, 'template');
			}
			return $buffer;

		}
		else {
			return '';
		}
	}

	public function deleteCache() {
		return $this->deleteFromCache($this->template, 'template');
	}



	public function __toString() {
		$buffer=$this->render();
		return $buffer;
	}




}


