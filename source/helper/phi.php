<?php


function slugify($string)
{

    $normalized = $string;
    $normalized = removeAccent($normalized);
    $normalized=preg_replace('`\W`', '-', $normalized);
    $normalized=preg_replace('`-+`', '-', $normalized);
    return $normalized;
}


function normalizeFilepath($filepath)
{
    return str_replace('\\', '/', (string)$filepath);
}

function filepathToClassName($string)
{

    $string = strtolower(str_replace(
        '.php',
        '',
        str_replace('/', '\\', $string)
    ));


    $string = str_replace('\class\\', '\\', $string);

    return $string;
}

function removeAccent($str, $charset = 'utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);
    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    return $str;
}




function obinclude($file, $variables = array())
{
    ob_start();
    extract($variables);
    include($file);
    return ob_get_clean();
}







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

