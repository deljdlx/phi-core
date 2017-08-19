<?php

function rglob($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
    {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}



function isClosure($variable)
{
    return is_object($variable) && ($variable instanceof Closure);
}




function includePhiModule($moduleName)
{
    $bootstrap = realpath(__DIR__ . '/../module') . '/' . escapeshellcmd($moduleName) . '/bootstrap.php';
    if (is_file($bootstrap) && $bootstrap) {
        include($bootstrap);
    }
}


function getInstance($className, $parameters = array())
{

    if (!class_exists($className)) {
        throw new \Phi\Exception('Class "' . $className . '" does not exist');
    } else {
        $reflector = new ReflectionClass($className);
        $instance = $reflector->newInstanceArgs($parameters);
        return $instance;
    }
}

