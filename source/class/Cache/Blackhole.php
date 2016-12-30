<?php
namespace Phi\Cache;




use Phi\Interfaces\CacheDriver;

class Blackhole implements CacheDriver
{


    public function exists($key) {
        return false;
    }

    public function get($key) {
        return false;
    }

    public function set($key) {
        return false;
    }
}
