<?php
require( __DIR__.'/bootstrap.php');


if(isset($argv[2])) {
	if(is_file($argv[2])) {
		include($argv[2]);
	}
	else {
		echo "\nFile ".$argv[2]." no found";
	}
}



