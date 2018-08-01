<?php

class Dasy {
	private $directory, $cache_directory;
	private static $directory_s;
	public function __construct($directory) {
		$this->directory = $directory;
		self::$directory_s = $directory;
		$this->cache_directory = 'dasy_cache';
	}

	private static function genere_path($file, $directory = '') {
		$directory = $directory === '' ? self::$directory_s : $directory;
		return $directory.'/'.$file.'.dasy.php';
	}

	public static function create($directory) {
		return new Dasy($directory);
	}

	private function dasy_create_cache_directory() {
		if(!is_dir($this->cache_directory)) {
			mkdir($this->cache_directory, 0777, true);
		}
	}

	private function dasy_create_cache(array $files) {
		$this->dasy_create_cache_directory();
		foreach ($files as $filename => $filecontent) {
			file_put_contents($this->cache_directory.'/'.base64_encode(basename($filename)).'.php', $filecontent);
		}
	}

	private function get_cache_file($cache_file) {
		$cache_file = base64_encode($cache_file.'.dasy.php').'.php';
		if(is_file($this->cache_directory.'/'.$cache_file)) {
			return $this->cache_directory.'/'.$cache_file;
		}
		return '';
	}

	public function make($template = '', array $params = [], $file = true) {
		if($file) {
			$this->dasy_create_cache([
				self::genere_path($template) => (new file_parser(self::genere_path($template)))->display()
			]);
			return $this->get_cache_file($template);
		}
		$this->dasy_create_cache((new dasy_parser($this->directory))->parse()->display());
		return null;
	}
}