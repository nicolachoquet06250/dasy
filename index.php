<?php

require_once "dasy/autoload.php";

$test = ['toto', 'tata'];

require Dasy::create('views')->make('index');
echo "\n";