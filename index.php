<?php

require_once "dasy/autoload.php";

//php_bloc::get_all('views/index.dasy.php');

$test = ['toto', 'tata'];

require Dasy::create('views')->make('index');
echo "\n";