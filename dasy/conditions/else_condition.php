<?php

class else_condition implements module {

	private $file_content;
	private function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public static function create($file_content) {
		return new else_condition($file_content);
	}

	private function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`else[\ ]{0,}{([^;]+)\}\;`', function ($matches) use (&$file_content) {
			$function = $matches[1];

			$function = str_replace("\n", ";\n", $function);

			$if = '<?php else ';
			$if .= ' {';
			$if .= $function;
			$if .= '} ?>';

			$if = str_replace('{;', '{', $if);

			$file_content = str_replace($matches[0], $if, $file_content);
		}, $this->file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}