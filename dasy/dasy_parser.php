<?php

class dasy_parser implements module {
	private $directory;
	public function __construct($directory) {
		$this->directory = $directory;
	}

	public function parse() {
		$dir = opendir($this->directory);
		while (($file = readdir($dir)) !== false) {
			(new file_parser($this->directory.'/'.$file))->parse();
		}
		return $this;
	}

	public function display() {
		return [''];
	}
}