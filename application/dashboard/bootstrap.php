<?php

require(__DIR__.'/../../bootstrap.php');

includePhiModule('Frontend');

ini_set('display_errors', 'on');


$dom=new \Phi\Module\Frontend\DOMTemplate();






$template='
	<html>
		<div>
			<p>test</p>
			placeholder value : "<content select=".test"/>"
		</div>
	</html>
';


echo $dom->render($template, array(
	'.test'=>'hello world'
));


