<?php

require_once "dasy/autoload.php";


try {
	Dasy::create('views')->make('page_test', [
		'charset'    => 'utf-8',
		'page_title' => 'Test Tableau - Json source',
		'menu_onglets' => [
			'onglet_1' => '/',
			'onglet_2' => '/test_page.php',
		],
		'tableau' => json_decode(file_get_contents('table.json')),
	]);
	echo "\n";
} catch (DasyHttpException $e) {
	try {
		dasy_http_errors::create($e);
	} catch (Exception $e) {
		exit($e->getMessage());
	}
}