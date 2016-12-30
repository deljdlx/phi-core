<?php



namespace Bienvenue\Configuration;


class Router extends \Phi\Routing\Router
{

	public function __construct() {



		$this->get('`/module/(?P<moduleName>.*?)/(?P<methodName>.*?)'.$this->getEndRouteRegexp().'`', function($moduleName, $methodName) {

			$controllerName='\Bienvenue\Module\\'.$moduleName.'\\'.$moduleName;

			$controller=getClassInstanceByName($controllerName);


			if(method_exists($controller, $methodName)) {
				echo $controller->$methodName();
				return true;
			}
		});

		$this->get('`.*`', function() {
			$index=new \Bienvenue\Module\Index\Index();
			echo $index->getHTML();
			return true;
		});
	}


}

