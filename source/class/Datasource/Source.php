<?php


namespace Phi\DataSource;




use Phi\DataSource\Interfaces\Driver;
use Phi\Object;


/**
 * Class Source
 * @property Driver source
 * @package Phi\DataSource
 */

class Source extends Object
{

    protected $source=null;

    public function __construct(Driver $source) {
        $this->source=$source;
    }



    public function getDriver() {
        return $this->source;
    }


    public function escape($string) {
        return $this->source->escape($string);
    }

    public function query($query) {
        $statement=$this->source->query($query);
        return $statement;
    }


    public function queryAndFetch($query) {

        $statement=$this->query($query);
        $returnValues=array();
        if($statement) {
            while($row=$statement->fetchAssoc()) {
                $returnValues[]=$row;
            }
        }
        return $returnValues;
    }

    public function queryAndFetchOne($query) {

        $returnValues=array();
        $statement=$this->query($query);
        if($statement) {
            $returnValues=$statement->fetchAssoc();
        }
        return $returnValues;
    }

    public function queryAndFetchValue($query) {
        $row=$this->queryAndFetchOne($query);
        if(!empty($row)) {
            return reset($row);
        }
        else {
            return false;
        }
    }


}




