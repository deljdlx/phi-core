<?php
namespace Phi\Core;



class Autoloader
{

    const DEFAULT_INSTANCE_NAME ='PHI_DEFAULT_AUTOLOADER';

    protected static $instances = [];


    protected $namespaces = array();
    protected $classIndex = false;


    public static function getInstance($instanceName = self::DEFAULT_INSTANCE_NAME)
    {
        if(!array_key_exists($instanceName, static::$instances)) {
            static::$instances[$instanceName] = new static;
        }

        return static::$instances[$instanceName];

    }

    public function __construct()
    {

    }


    public function addNamespace($namespace, $folder)
    {


        $namespace = preg_replace('`^\\\\`', '', $namespace);


        $folder = $this->normalizeFilepath($folder);
        $this->namespaces[$namespace] = $folder;




        if (is_dir($folder)) {


            $dir_iterator = new \RecursiveDirectoryIterator($folder);

            $iterator = new \RecursiveIteratorIterator($dir_iterator, \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($iterator as $file) {


                if (strrpos($file, '.php') !== false) {

                    $fileName = str_replace('\\', '/', (string)$file);
                    $className = $this->filepathToClassName(str_replace($folder, $namespace, $fileName));


                    $this->classIndex[strtolower($className)] = (string)$file;

                    /*
                     * handling classes with name like \namespace\className\ClassName
                     * convert them to \namespace\className
                     * not psr-4 ; used for components
                     */
                    if (
                        basename($this->normalizeFilepath($className)) ==
                        basename(dirname($this->normalizeFilepath($className)))
                    ) {
                        $className = $this->filepathToClassName(dirname($this->normalizeFilepath($className)));
                        $this->classIndex[strtolower($className)] = (string)$file;
                    }


                }
            }
        }
        else {
            throw new \Exception('Folder '.$folder.' does not exist');
        }

        return $this;
    }




    public function register()
    {
        spl_autoload_register(function ($calledClassName) {
            $this->autoload($calledClassName);
        });
    }


    public function normalizeFilepath($filepath)
    {
        return str_replace('\\', '/', (string)$filepath);
    }

    public function filepathToClassName($string)
    {

        $string = strtolower(str_replace(
            '.php',
            '',
            str_replace('/', '\\', $string)
        ));

        $string = str_replace('\class\\', '\\', $string);

        return $string;
    }



    protected function autoload($calledClassName)
    {
        $normalizedClassName = strtolower($calledClassName);





        if (isset($this->classIndex[$normalizedClassName])) {
            include($this->classIndex[$normalizedClassName]);
            return true;
        }
        return false;
    }

}