<?php

class Dasy {
	private $directory;
	private static $directory_s;
	private static $params = [];
	public function __construct($directory) {
		$this->directory = $directory;
		self::$directory_s = $directory;
	}

	private static function genere_path($file, $directory = '') {
		$directory = $directory === '' ? self::$directory_s : $directory;
		return $directory.'/'.$file.'.dasy.php';
	}

	public static function create($directory) {
		return new Dasy($directory);
	}

	public static function assign($var, $value) {
		self::$params[$var] = $value;
	}

	public static function complete_params($params) {
		foreach ($params as $var => $value) {
			self::assign($var, $value);
		}
	}

	public static function get_params() {
		return self::$params;
	}

	public static function get_param($var) {
		return isset(self::$params[$var]) ? self::$params[$var] : null;
	}

	public function make($template = '', array $params = [], $file = true) {
		self::complete_params($params);
		if($file) {
			$path = self::genere_path($template);
			try {
				dasy_cache::create([
					$path => file_parser::create(php_bloc::get_all($path), $path)->display()
				]);
			} catch (Exception $e) {}
			foreach ($params as $name => $value) {
				$$name = $value;
			}
			include dasy_cache::get($template);
			dasy_cache::delete($template);
			exit();
		}
		try {
			dasy_cache::create(dasy_parser::create($this->directory)->display());
		} catch (Exception $e) {}
		return null;
	}
}