<?php

class php_bloc {
	private $file;
	private function __construct($file) {
		$this->file = $file;
	}

	public function get_file($content = false) {
		if(is_file($this->file)) {
			return $content ? file_get_contents($this->file) : $this->file;
		}
		return null;
	}

	public static function get_all($file) {
		$php_bloc_parser = new php_bloc($file);
		$contents = [];
		if($php_bloc_parser->get_file()) {
			$content = $php_bloc_parser->get_file(true);
			preg_replace_callback('`(\<php\>)([^²]+)(\<\/php\>)²`', function ($matches) use (&$contents) {
				$contents[] = $matches;
			}, $content);
		}

		return $contents;
	}
}