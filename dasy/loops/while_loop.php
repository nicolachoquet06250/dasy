<?php

class while_loop implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	protected function parse() {
		$file_content = $this->file_content;
		preg_replace_callback('`\@while\(\(([\$a-zA-Z0-9\_\<\>\-\=\*\+\/\&\|\\\'\"\ ]+)\)\ \=\>\ \{([^\}\)]+)\}\)\;`', function ($matches) use (&$file_content) {
			$for = '<?php ';
			$for .= 'while(';
			$for .= $matches[1];
			$for .= ')';
			$for .= ' {';
			$for .= $matches[2];
			$for .= '}';
			$for .= ' ?>';
			$file_content = str_replace($matches[0], $for, $file_content);
		}, $this->file_content);
		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}