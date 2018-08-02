<?php

class variable implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	protected function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`(let|var) ([a-zA-Z0-9\_\-\$]+)\=([^µ\;]+);\n`', function ($matches) use (&$file_content) {
			$var = '<?php ';
			$var .= '$'.$matches[2];
			$var .= '=';
			$var .= $matches[3];
			$var .= ';';
			$var .= ' ?>'."\n";
			$file_content = str_replace($matches[0], $var, $file_content);
		}, $this->file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}