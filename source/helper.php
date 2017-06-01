<?php

$helpers = glob(__DIR__ . '/helper/*.php');

foreach ($helpers as $helper) {
    include($helper);
}
