<?php


namespace Bienvenue\Module\Index;

use Phi\Controller;
use Phi\PHPTemplate;


class Index extends Controller
{


	public function getHTML() {
		$template=new PHPTemplate();
		return $template->render(__DIR__.'/template/index.php');
	}


}






