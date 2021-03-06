<?php

require_once "dasy/autoload.php";


try {
	Dasy::create('views')->make('index', [
		'charset'    => 'utf-8',
		'page_title' => 'première page du gestionnaire de template',
		'test'       => ['toto', 'tata'],
	]);
	echo "\n";
} catch (DasyHttpException $e) {
	try {
		dasy_http_errors::create($e);
	} catch (Exception $e) {
		exit($e->getMessage());
	}
}