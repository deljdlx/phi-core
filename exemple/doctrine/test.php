<?php

require(__DIR__.'/bootstrap.php');



$repository=$entityManager->getRepository('Exemple\Doctrine\Entity\Test');
$testInstance=new Exemple\Doctrine\Entity\Test(uniqid(), "hello world");
$entityManager->persist($testInstance);
$entityManager->flush();


