<?php


include(__DIR__ . '/../bootstrap.php');
ini_set('display_errors', 'on');


class Test implements ArrayAccess
{
    use Phi\Traits\Collection;
}


$test=new Test();

$test['hello']='world';


echo "key hello : ", $test->getVariable('hello');

echo '<hr/>';
$test->setVariable('world', 'hello');

echo "key world : ", $test['world'];