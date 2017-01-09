<?php
namespace Phi\Interfaces\DataSource;



interface Driver
{



	public function escape($value);
	public function query($query);


	public function getLastInsertId();



	//public function commit();
	//public function autocommit($value=null);




}




