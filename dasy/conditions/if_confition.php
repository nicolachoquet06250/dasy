<?php

class if_confition implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	private function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`\@if\(\(([\$a-zA-Z0-9\&\|\=\<\>\/\-\+\"\\\'\!\(\)\[\] ]+)\) \=\> \{([^\}\)]+)\}\);`', function ($matches) use (&$file_content) {
			$if = '<?php ';
			$if .= 'if(';
			$if .= $matches[1];
			$if .= ')';
			$if .= ' {';
			$if .= $matches[2];
			$if .= '}';
			$if .= ' ?>';
			$file_content = str_replace($matches[0], $if, $file_content);
		}, $this->file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}