<?php

namespace Phi\Core;

class VirtualPathManager
{

    protected static $mainInstance;

    protected $virtualPathes = [];


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


    public function registerPath($realPath, $virtualPath)
    {

        $this->virtualPathes[$virtualPath] = realpath($realPath);
        $this->virtualPathes[$realPath] = realpath($realPath);

        return $this;
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