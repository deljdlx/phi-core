<?php


include(__DIR__.'/../../bootstrap.php');
ini_set('display_errors', 'on');



use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;



$isDevMode = true;

$configuration=Setup::createConfiguration($isDevMode);
$driver = new \Doctrine\Common\Persistence\Mapping\Driver\PHPDriver(__DIR__.'/mapping');
$configuration->setMetadataDriverImpl($driver);

//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);


// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/data/db.sqlite',
);

$entityManager = EntityManager::create($conn, $configuration);





