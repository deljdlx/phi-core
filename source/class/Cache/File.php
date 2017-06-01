<?php
namespace Phi\Cache;


use Phi\Cache\Interfaces\Driver;

class File implements Driver
{

    protected $cacheFilepathRoot = null;


    public function exists($key)
    {
        if (!$this->cacheFilepathRoot) {
            return false;
        }

        if (is_file($this->getFilepath($key))) {
            return true;
        } else {
            return false;
        }


    }

    public function get($key)
    {
        if (!$this->cacheFilepathRoot) {
            return false;
        }

        if ($this->exists($key)) {
            return file_get_contents($this->getFilepath($key));
        } else {
            return false;
        }
    }

    public function set($key, $data)
    {
        if (!$this->cacheFilepathRoot) {
            return false;
        }

        $filepath = $this->getFilepath($key);
        if ($filepath) {
            return file_put_contents(
                $filepath,
                $data
            );
        }
        return false;
    }


    public function getFilepath($key)
    {

        if ($this->cacheFilepathRoot && is_dir($this->cacheFilepathRoot)) {
            $slug = slugify($key);
            return $this->cacheFilepathRoot . '/' . $slug . '.cache';
        } else {
            return false;
        }


    }


}
