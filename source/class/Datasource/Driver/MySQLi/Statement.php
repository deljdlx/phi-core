<?php


namespace Phi\DataSource\Driver\MySQLi;
use \Phi\DataSource\Interfaces\Statement as PhiStatement;

/**
 * Class Statement
 * @property \MySQLi_result statement
 * @package Phi\DataSource\SQLite3
 */

class Statement implements PhiStatement
{

	protected $statement;

	public function __construct(\MySQLi_result  $statement) {
		$this->statement=$statement;
	}

	public function fetchAssoc() {
		return $this->statement->fetch_assoc();
	}



}



