<?php

class variable implements module {

	private $file_content;
	private function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public static function create($file_content) {
		return new variable($file_content);
	}

	protected function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`(let|var) ([a-zA-Z0-9\_\-\$]+)[\ ]{0,}\=[\ ]{0,}([^µ\;]+);\n`', function ($matches) use (&$file_content) {
			$var = '<?php ';
			$var .= '$'.$matches[2];
			$var .= '=';
			$var .= strstr($matches[3], '[{') || strstr($matches[3], ': {') || strstr($matches[3], ': [') || strstr($matches[3], ', {')
					? 'json_decode(\''.$matches[3].'\')' : $matches[3];
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