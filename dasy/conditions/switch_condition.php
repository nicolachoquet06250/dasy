<?php

class switch_condition implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public function switch_case() {

	}

	private function parse() {
		$file_content = $this->file_content;



		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}