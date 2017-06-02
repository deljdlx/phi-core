<?php


include(__DIR__.'/../bootstrap.php');
ini_set('display_errors', 'on');


$template=new \Phi\Template\PHPTemplate('<h1>hello world <?php echo $name;?></h1>');

echo $template->render(null, array(
    'name' => 'John Do'
));

