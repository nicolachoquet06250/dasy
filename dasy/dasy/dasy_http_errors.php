<?php

class dasy_http_errors {
	private function __construct() {}

	public static function create(Exception $e) {
		$code = explode(' - ', $e->getMessage())[0];
		$method = 'e_'.$code;
		$message = explode(' - ', $e->getMessage())[1];
		self::$method($message);
	}

	public function e_404($message = 'Not Found') {
		header('HTTP/1.0 404 '.$message);
	}

	public function e_500($message = 'Server Error') {
		header('HTTP/1.0 500 '.$message);
	}
}