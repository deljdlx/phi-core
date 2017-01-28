<?php
namespace Phi\Cache\Interfaces;




interface CacheDriver
{

    public function exists($key);
    public function get($key);
    public function set($key, $data);

}