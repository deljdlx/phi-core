<?php
namespace Phi\DataSource\Interfaces;



interface Driver
{



	public function escape($value);
	public function query($query);


	public function getLastInsertId();



	//public function commit();
	//public function autocommit($value=null);




}




