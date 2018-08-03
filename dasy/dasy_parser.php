<?php

class dasy_parser implements module {
	private $directory;
	private $file_content;
	private function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public static function create($file_content) {
		return new dasy_parser($file_content);
	}

	/**
	 * @return $this
	 * @throws Exception
	 */
	private function parse() {
		$dir = opendir($this->directory);
		while (($file = readdir($dir)) !== false) {
			$path = $this->directory.'/'.$file;
			var_dump($path);
			file_parser::create(php_bloc::get_all($path), $path)->display();
		}
		return $this;
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	public function display() {
		$this->parse();
		return [''];
	}
}