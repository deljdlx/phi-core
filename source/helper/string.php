<?php

function slugify($string)
{

    $normalized = $string;
    $normalized = removeAccent($normalized);
    $normalized=preg_replace('`\W`', '-', $normalized);
    $normalized=preg_replace('`-*`', '-', $normalized);


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



