<?php



include(__DIR__.'/../bootstrap.php');
ini_set('display_errors', 'on');







$driver=new \Phi\DataSource\Driver\MySQLi\Source('127.0.0.1', 'root', '', 'test');
$driver->autocommit();


/*
$driver->query('
	CREATE TABLE test (
		id INTEGER,
		caption VARCHAR (255)
	)
');
*/

for($i=1; $i<11; $i++) {
	$driver->query("
		INSERT INTO test VALUES(
		 	".$i.",
		 	'".$driver->escape(md5(uniqid()))."'
		)
	");
}


$selectQuery='SELECT * FROM test';
$statement=$driver->query($selectQuery);
$rows=$statement->fetchAll();


echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($rows);
echo '</pre>';


echo '<hr/>';

$source=new \Phi\DataSource\Source($driver);


echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($source->queryAndFetch($selectQuery));
echo '</pre>';

echo '<hr/>';

$source=new \Phi\DataSource\Source($driver);
echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($source->queryAndFetchOne($selectQuery));
echo '</pre>';






