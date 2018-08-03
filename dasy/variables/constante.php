<?php

class constante implements module {

	private $file_content;
	private function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public static function create($file_content) {
		return new constante($file_content);
	}

	protected function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`define ([a-zA-Z0-9\_\-]+)[\ ]{0,}\=[\ ]{0,}([^\;]+);`', function ($matches) use (&$file_content) {
			$var = '<?php ';
			$var .= 'define(\''.$matches[1];
			$var .= '\', ';
			$var .= $matches[2];
			$var .= ');';
			$var .= ' ?>';
			$file_content = str_replace($matches[0], $var, $file_content);
		}, $this->file_content);

		preg_replace_callback('`const ([a-zA-Z0-9\_\-]+)\=([^\;]+);`', function ($matches) use (&$file_content) {
			$var = '<?php ';
			$var .= 'const '.$matches[1];
			$var .= '=';
			$var .= $matches[2];
			$var .= ' ?>';
			$file_content = str_replace($matches[0], $var, $file_content);
		}, $this->file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}