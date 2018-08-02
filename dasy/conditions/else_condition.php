<?php

class else_condition implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	private function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`else[\ ]{0,}{([^\µ]+)\}`', function ($matches) use (&$file_content) {
			$function = $matches[1];

			$if = 'else ';
			$if .= ' {';
			$if .= $function;
			$if .= '}';

			$file_content = str_replace($matches[0], $if, $file_content);
		}, $this->file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}