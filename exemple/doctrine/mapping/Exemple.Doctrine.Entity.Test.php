<?php

/**
 * @var Doctrine\ORM\Mapping\ClassMetadata $metadata
 */


echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($metadata);
echo '</pre>';


$metadata->setPrimaryTable(array(
    'name'=>'test'
));

$metadata->setCustomRepositoryClass('Exemple\Doctrine\Repository\Test');

$metadata->mapField(array(
    'id' => true,
    'fieldName' => 'id',
    'type' => 'integer'
));

$metadata->mapField(array(
    'fieldName' => 'caption',
    'type' => 'string',
    'options' => array(
        'fixed' => true,
        'comment' => "User's login name"
    )
));