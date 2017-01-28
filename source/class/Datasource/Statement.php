<?php


namespace Phi\DataSource;
use \Phi\DataSource\Interfaces\Statement as PhiStatement;

/**
 * Class Statement
 * @property \Phi\DataSource\Interfaces\Statement driver
 * @package Phi\DataSource
 */

class Statement
{

	protected $driver;

	public function __construct(PhiStatement $statement) {
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