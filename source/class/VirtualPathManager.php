<?php

namespace Phi\Core;

class VirtualPathManager
{

    protected static $mainInstance;

    protected $virtualPathes = [];
    protected $virtualPathesByName = [];


    /**
     * @return static
     *
     */
    public static function getInstance()
    {
        if(!static::$mainInstance) {
            static::$mainInstance = new static();
        }
        return static::$mainInstance;
    }


    public function registerPath($realPath, $virtualPath, $name = null)
    {

        if(is_dir($virtualPath)) {
            $this->virtualPathes[$virtualPath] = $virtualPath;
            if($name) {
                $this->virtualPathesByName[$name] = &$this->virtualPathes[$virtualPath];
            }
            return $this;
        }

        $path = realpath($realPath);

        if(!$path) {
            throw new Exception('Path "'.$realPath.'" does not exists');
        }

        $this->virtualPathes[$virtualPath] = $path;
        $this->virtualPathes[$realPath] = $path;

        if($name) {
            $this->virtualPathesByName[$name] = &$this->virtualPathes[$virtualPath];
        }

        return $this;
    }

    public function getPathByName($name)
    {
        if(array_key_exists($name, $this->virtualPathesByName)) {
            return $this->virtualPathesByName[$name];
        }
        else {
            throw new Exception('Virtual path with name "'.$name.'" is not registered');
        }
    }


    public function getPath($path)
    {
        if(is_dir(realpath($path))) {
            return realpath($path);
        }

        if(array_key_exists($path, $this->virtualPathes)) {
            return $this->virtualPathes[$path];
        }
        else {
            throw new Exception('Virtual path "'.$path.'" is not registered');
        }
    }


    public function buildSymlinks()
    {
        foreach ($this->virtualPathes as $virtual => $real) {
            if(!is_dir($virtual)) {
                symlink($real, $virtual);
                echo $virtual .'->'. $real;
                echo "\n";
            }
        }
    }

    public function deploy($source, $destination)
    {
        $this->buildSymlinks();
        $this->rcopy($source, $destination);
    }


    protected function rcopy($source, $dest, $createDir = false)
    {
        // recursive function to copy
        // all subdirectories and contents:
        if(is_dir($source)) {
            $dir_handle=opendir($source);
            $sourcefolder = basename($source);

            if($createDir) {
                mkdir($dest."/".$sourcefolder);
                $destinationPath = $dest."/".$sourcefolder;
            }
            else {
                $destinationPath = $dest;
            }

            while($file=readdir($dir_handle)){
                if($file!="." && $file!=".."){
                    if(is_dir($source."/".$file)){
                        $this->rcopy($source."/".$file, $destinationPath, true);
                    } else {

                        echo $source."/".$file."\t => \t".$destinationPath."/".$file;
                        echo "\n";

                        copy($source."/".$file, $destinationPath."/".$file);
                    }
                }
            }
            closedir($dir_handle);
        } else {
            // can also handle simple copy commands
            copy($source, $dest);
        }
    }







}