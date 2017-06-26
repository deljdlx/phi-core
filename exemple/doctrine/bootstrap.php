<?php


include(__DIR__.'/../../bootstrap.php');
ini_set('display_errors', 'on');





// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);



// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

$driver = new \Doctrine\Common\Persistence\Mapping\Driver\PHPDriver(__DIR__.'/mapping');
$entityManager->getConfiguration()->setMetadataDriverImpl($driver);

//print_r($entityManager);

//die('EXIT '.__FILE__.'@'.__LINE__);
include(__DIR__.'/test.entity.php');
include(__DIR__.'/repository/TestRepository.php');


/*
$repository=$entityManager->getRepository('Test');

echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($repository);
echo '</pre>';
die('EXIT '.__FILE__.'@'.__LINE__);
*/
