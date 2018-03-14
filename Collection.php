<?php
namespace Phi\Core;


class Collection implements \Iterator
{

    private $collection = array();
    private $cursor = 0;


    public function current ()
    {
        return $this->collection[$this->cursor];
    }

    public function key()
    {
        return $this->cursor;
    }
    public function next()
    {
        $this->cursor++;
    }

    public function rewind ()
    {
        $this->cursor = 0;
    }

    public function valid ()
    {
        return array_key_exists($this->cursor, $this->collection);
    }

}