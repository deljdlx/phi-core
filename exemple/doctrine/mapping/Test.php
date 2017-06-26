<?php

/**
 * @var Doctrine\ORM\Mapping\ClassMetadata $metadata
 */


$metadata->setPrimaryTable(array(
    'name'=>'test'
));

$metadata->setCustomRepositoryClass('TestRepository');

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