<?php
require(__DIR__.'/../bootstrap.php');

?>
<!doctype html>
<html>
<head>
    <title>Tests control panel</title>
    <script src="asset/vendor/jquery-2.2.3.min.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="asset/vendor/materialize/dist/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="asset/vendor/materialize/dist/js/materialize.min.js"></script>


</head>
<h1>
</h1>

<?php



$dir_iterator = new RecursiveDirectoryIterator(realpath(__DIR__.'/../test'));
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iterator as $file) {
    if(stripos($file, '.test.php')) {


        $className='\PhiTestCase\\'.str_replace('.test.php', '', basename($file));
        if(class_exists($className)) {
            $test=new $className();
            $results=$test->run();
            echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
            echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
            print_r($results);
            echo '</pre>';

        }
    }
}


?>



</html>