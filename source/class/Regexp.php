<?php


namespace Phi\Core;

class Regexp
{

    private $regexp;

    private $flags = [];


    private $delimiter = '`';


    private $matches = [];

    public function __construct($regexp, $flags = [])
    {
        $this->regexp = $regexp;
        $this->flags = $flags;
    }

    public function match($string)
    {
        return preg_match_all($this->compile(), $string, $this->matches);
    }


    public function compile()
    {
        return
            $this->delimiter.
                $this->regexp.
            $this->delimiter.
            implode('', $this->flags)
        ;
    }


    public function getMatches()
    {
        return $this->matches;
    }


}
