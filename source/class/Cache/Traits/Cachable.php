<?php
namespace Phi\Cache\Traits;



use Phi\Cache\Blackhole;
use Phi\Cache\Interfaces\CacheDriver;


/*
 *
 * @var \Premium\Interfaces\CacheDriver $cacheDriver
 */

Trait Cachable
{



    protected $defaultCacheDriver;
    protected $cacheDriver;


    public function setCacheDriver(CacheDriver $cacheDriver) {
        $this->cacheDriver=$cacheDriver;
        return $this;
    }

    public function getDefautCacheDriver() {
        if(!$this->defaultCacheDriver) {
            $this->defaultCacheDriver=new Blackhole();
        }
        return $this->defaultCacheDriver;
    }

    public function initializeCacheDriver() {
        if(!$this->cacheDriver) {
            $this->cacheDriver=$this->getDefautCacheDriver();
        }
    }



    public function existsInCache($key, $namespace=null) {
        $this->initializeCacheDriver();

        $innerKey=$this->buildKey($key, $namespace);
       return $this->cacheDriver->exists($innerKey);
    }

    public function getFromCache($key, $namespace=null) {
        $this->initializeCacheDriver();

        $innerKey=$this->buildKey($key, $namespace);
        return $this->cacheDriver->get($innerKey);
    }

    public function saveInCache($key, $data, $namespace=null) {
        $this->initializeCacheDriver();

        $innerKey=$this->buildKey($key, $namespace);
        return $this->cacheDriver->set($innerKey, $data);
    }


    protected function buildKey($key, $namespace='default') {
        return 'cache://'.$namespace.':'.$key;
    }



}
