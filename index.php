<?php

require_once "dasy/autoload.php";

Dasy::create('views')->make('index', [
	'charset' => 'utf-8',
	'page_title' => 'première page du gestionnaire de template',
	'test' => ['toto', 'tata'],
]);
echo "\n";