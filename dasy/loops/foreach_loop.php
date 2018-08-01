<?php

class foreach_loop implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	protected function parse() {
		$file_content = $this->file_content;
		preg_replace_callback('`\@(\$[a-zA-Z0-9\_\-]+)\-\>each\(\((\$[a-zA-Z0-9\-\_]+)\)\ \=\>\ \{([^\}\)]+)\}\);`', function ($matches) use (&$file_content) {
			$foreach = '<?php ';
			$foreach .= 'foreach(';
			$foreach .= $matches[1];
			$foreach .= ' as ';
			$foreach .= $matches[2];
			$foreach .= ')';
			$foreach .= ' {';
			$foreach .= $matches[3];
			$foreach .= '}';
			$foreach .= ' ?>';
			$file_content = str_replace($matches[0], $foreach, $file_content);
		}, $this->file_content);

		preg_replace_callback('`\@(\$[a-zA-Z0-9\_\-]+)\-\>each\(\((\$[a-zA-Z0-9\-\_]+)\, (\$[a-zA-Z0-9\-\_]+)\)\ \=\>\ \{([^\}\)]+)\}\);`', function ($matches) use (&$file_content) {
			$foreach = '<?php ';
			$foreach .= 'foreach(';
			$foreach .= $matches[1];
			$foreach .= ' as ';
			$foreach .= $matches[2];
			$foreach .= ' => ';
			$foreach .= $matches[3];
			$foreach .= ')';
			$foreach .= ' {';
			$foreach .= $matches[4];
			$foreach .= '}';
			$foreach .= ' ?>';
			$file_content = str_replace($matches[0], $foreach, $file_content);
		}, $this->file_content);
		return $file_content;
	}

	public function display() {
		return $this->parse();
	}
}