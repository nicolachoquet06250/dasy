<?php

class dasy_http_errors {
	private function __construct() {}

	/**
	 * @param DasyHttpException $e
	 * @throws Exception
	 */
	public static function create(DasyHttpException $e) {
		$code = explode(' - ', $e->getMessage())[0];
		$method = 'e_'.$code;
		$message = explode(' - ', $e->getMessage())[1];
		if(in_array($method, get_class_methods(self::class))) {
			self::$method($e, $message);
			exit();
		}
		header('HTTP/1.0 '.$code.' '.$message);
		throw new Exception('<h1>'.$code.'</h1><br>'.$message);
	}

	/**
	 * @param DasyHttpException $e
	 * @param string            $message
	 * @throws Exception
	 */
	public function e_404(DasyHttpException $e, $message = 'Not Found') {
		header('HTTP/1.0 404 '.$message);
		Dasy::create()->make_error('/404', $e->get_params());
	}

	/**
	 * @param DasyHttpException $e
	 * @param string            $message
	 * @throws Exception
	 */
	public function e_500(DasyHttpException $e, $message = 'Server Error') {
		header('HTTP/1.0 500 '.$message);
		Dasy::create()->make_error('/404', $e->get_params());
	}
}