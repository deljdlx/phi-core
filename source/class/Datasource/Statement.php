<?php


namespace Phi\DataSource;


/**
 * Class Statement
 * @property \Phi\Interfaces\DataSource\Statement driver
 * @package Phi\DataSource
 */

class Statement
{

	protected $driver;

	public function __construct(\Phi\Interfaces\DataSource\Statement $statement) {
		$this->driver=$statement;
	}


	public function fetchAssoc() {
		return $this->driver->fetchAssoc();
	}

	public function fetchAll() {
		$returnValues=array();
		if($this->driver) {
			while($row=$this->driver->fetchAssoc()) {
				$returnValues[]=$row;
			}
		}
		return $returnValues;
	}



}