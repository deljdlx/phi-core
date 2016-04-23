<?php


require(__DIR__.'/../../../bootstrap.php');



$manager=new \Phi\Asset\Manager();



$deployer=new \Phi\Asset\Deployer(__DIR__.'/deploy', './deploy');

$manager->setDeployer($deployer);


$jQuery=new \Phi\Asset\Javascript('http://code.jquery.com/jquery-2.2.2.min.js');
$manager->registerAsset($jQuery);


$localJs=new \Phi\Asset\Javascript('file://'.__DIR__.'/asset/test.js');
$manager->registerAsset($localJs);
$manager->deployResource($localJs);


$localJs2=new \Phi\Asset\Javascript('file://'.__DIR__.'/asset/test2.js');
$manager->registerAsset($localJs2);



$manager->merge();
$manager->deployMergedJavascript();



//echo $manager->renderHTMLTags();
