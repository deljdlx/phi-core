<?php


namespace Phi\Core;

class Regexp
{

    private $regexp;

    private $flags = [];


    private $delimiter = '`';


    /**
     * @var array
     */
    private $matches = [];

    /**
     * Regexp constructor.
     * @param $regexp
     * @param array $flags
     */
    public function __construct($regexp, array $flags = [])
    {
        $this->regexp = $regexp;
        $this->flags = $flags;
    }


    /**
     * @param $string
     * @return int
     */
    public function match($string): int
    {
        return preg_match_all($this->compile(), $string, $this->matches);
    }


    public function compile(): string
    {
        return
            $this->delimiter.
                $this->regexp.
            $this->delimiter.
            implode('', $this->flags)
        ;
    }

    /**
     * @return array
     */
    public function getMatches(): array
    {
        return $this->matches;
    }


}
