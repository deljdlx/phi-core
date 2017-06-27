<?php
namespace Exemple\Doctrine\Entity;


class Test
{

    private $id;
    private $caption;


    public function __construct($id, $caption)
    {
        $this->id = $id;
        $this->caption = $caption;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCaption()
    {
        return $this->caption;
    }

}