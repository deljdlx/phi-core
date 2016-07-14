<?php


function is_closure($variable) {
	return is_object($variable) && ($variable instanceof Closure);
}


function registerNamespace($namespace, $folder) {
	static $autoloader;
	static $componentAutoloader;
	if(!$autoloader) {
		$autoloader=new \Phi\Autoloader();
		spl_autoload_register(function($calledClassName) use ($autoloader) {
			$autoloader->autoload($calledClassName);
		});
	}
	$autoloader->addNamespace($namespace, $folder);


	if(!$componentAutoloader) {
		$componentAutoloader=new \Phi\PackageAutoloader();
		spl_autoload_register(function($calledClassName) use ($componentAutoloader) {
			$componentAutoloader->autoload($calledClassName);
		});
	}
	$componentAutoloader->addNamespace($namespace, $folder);
}




function includePhiModule($moduleName) {


	$bootstrap=realpath(__DIR__.'/../module').'/'.escapeshellcmd($moduleName).'/bootstrap.php';

	if(is_file($bootstrap) && $bootstrap) {
		include($bootstrap);

	}


}