<?php

class Dasy {
	private $directory;
	private static $directory_s;
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

	public function make($template = '', array $params = [], $file = true) {
		if($file) {
			dasy_cache::create([
				self::genere_path($template) => (new file_parser(php_bloc::get_all(self::genere_path($template)), self::genere_path($template)))->display()
			]);
			return dasy_cache::get($template);
		}
		dasy_cache::create((new dasy_parser($this->directory))->parse()->display());
		return null;
	}
}