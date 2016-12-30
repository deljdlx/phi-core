<?php


namespace Phi\DataSource\Driver\MySQLi;


/**
 * Class Statement
 * @property \MySQLi_result statement
 * @package Phi\DataSource\SQLite3
 */

class Statement implements \Phi\Interfaces\DataSource\Statement
{

	protected $statement;

	public function __construct(\MySQLi_result  $statement) {
		$this->statement=$statement;
	}

	public function fetchAssoc() {
		return $this->statement->fetch_assoc();
	}



}



