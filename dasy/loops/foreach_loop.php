<?php

class foreach_loop implements module {

	private $file_content;
	private function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public static function create($file_content) {
		return new foreach_loop($file_content);
	}

	protected function parse() {
		$file_content = $this->file_content;
		preg_replace_callback('`([a-zA-Z0-9\_]+).each[\ ]{0,}\([\ ]{0,}\(([a-zA-Z0-9\_]+)[\ ]{0,}\)[\ ]{0,}\=\>[\ ]{0,}\{([^;]+)\}\);`', function ($matches) use (&$file_content) {
			$array_or_object = '$'.$matches[1];
			$value = '$'.$matches[2];
			$fonction = $matches[3];
			$fonction = str_replace("\n", ";\n", $fonction);

			$foreach = '<?php ';
			$foreach .= 'foreach(';
			$foreach .= $array_or_object;
			$foreach .= ' as ';
			$foreach .= $value;
			$foreach .= ')';
			$foreach .= ' {';
			$foreach .= $fonction;
			$foreach .= '}';
			$foreach .= ' ?>';
			$foreach = str_replace('{;', '{', $foreach);

			$file_content = str_replace($matches[0], $foreach, $file_content);
		}, $this->file_content);

		preg_replace_callback('`([a-zA-Z0-9\_]+).each[\ ]{0,}\([\ ]{0,}\([\ ]{0,}([a-zA-Z0-9\_]+)[\ ]{0,}[\ ]{0,}\,[\ ]{0,}([a-zA-Z0-9\_]+)[\ ]{0,}\)[\ ]{0,}\=\>[\ ]{0,}\{([^;]+)\}\);`', function ($matches) use (&$file_content) {
			$array_or_object = '$'.$matches[1];
			$key = '$'.$matches[2];
			$value = '$'.$matches[3];
			$fonction = $matches[4];
			$fonction = str_replace("\n", ";\n", $fonction);

			$foreach = '<?php ';
			$foreach .= 'foreach(';
			$foreach .= $array_or_object;
			$foreach .= ' as ';
			$foreach .= $key;
			$foreach .= ' => ';
			$foreach .= $value;
			$foreach .= ')';
			$foreach .= ' {';
			$foreach .= $fonction;
			$foreach .= '}';
			$foreach .= ' ?>';
			$foreach = str_replace('{;', '{', $foreach);

			$file_content = str_replace($matches[0], $foreach, $file_content);
		}, $this->file_content);
		return $file_content;
	}

	public function display() {
		return $this->parse();
	}
}