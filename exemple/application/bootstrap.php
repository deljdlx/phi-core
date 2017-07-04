<?php

require(__DIR__ . '/../../bootstrap.php');
ini_set('display_errors', 'on');

$application = new \Phi\Application\Application(__DIR__);


$application->setCallback('hello world');
$application->run(null, true);



echo '<hr/>';

$application->setCallback(function (\Phi\Routing\Request $request) {
    return "hello world by callback";
});
$application->run(null, true);

echo '<hr/>';
$application = new \Phi\Application\Application(__DIR__);
$application->enableRouter();
$application->getRouter()->get('test', '`.*`', function() {
    echo 'hello world by route';
    return true;
});

$application->run();
echo $application->getOutput();



