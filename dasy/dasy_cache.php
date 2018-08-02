<?php

class dasy_cache {

	private static $directory = 'dasy_cache';

	public static function init_directory() {
		if(!is_dir(self::$directory)) {
			mkdir(self::$directory, 0777, true);
		}
	}

	public static function create($file) {
		self::init_directory();
		if(gettype($file) === 'array' && !isset($file[0]) && count($file) > 0) {
			foreach ($file as $filename => $filecontent) {
				file_put_contents(self::$directory.'/'.base64_encode(basename($filename)).'.php', $filecontent);
			}
		}
		elseif(gettype($file) === 'array' && isset($file[0]) && count($file) > 0) {
			$filename = $file[0];
			$filecontent = $file[1];
			file_put_contents(self::$directory.'/'.base64_encode(basename($filename)).'.php', $filecontent);
		}
	}

	public static function get($cache_file) {
		$cache_file = base64_encode($cache_file.'.dasy.php').'.php';
		if(is_file(self::$directory.'/'.$cache_file)) {
			return self::$directory.'/'.$cache_file;
		}
		return '';
	}

	public static function delete($cache_file) {
		$file = self::get($cache_file);
		if($file) {
			unset($file);
		}
	}
}