<?php

require(__DIR__.'/../../bootstrap.php');

$application=new \Phi\Application\Application(__DIR__);

echo "\n===============\n";
$application->setCallback('hello world');
$application->run(null, true);
echo "\n===============\n";

$application->setCallback(function(\Phi\Routing\Request $request) {
    return "hello world by callback";
});
$application->run(null, true);

echo "\n===============\n";



