<?php

class elseif_condition implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
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