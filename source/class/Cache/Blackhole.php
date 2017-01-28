<?php
namespace Phi\Cache;

use Phi\Cache\Interfaces\Driver;


class Blackhole implements Driver
{

    public function exists($key)
    {
        return false;
    }

    public function get($key)
    {
        return false;
    }

    public function set($key, $data)
    {
        return false;
    }
}
