<?php

class file_parser implements module {
	private $file_content;
	public function __construct($file_path) {
		$file_content = file_get_contents($file_path);
		$this->file_content = $file_content;
	}

	protected function parse() {
		$variable = (new variable($this->file_content))->display();
		$constante = (new variable($variable))->display();

		$if = (new if_confition($constante))->display();
		$else = (new else_condition($if))->display();
		$elseif = (new elseif_condition($else))->display();
		$switch = (new switch_condition($elseif))->display();

		$foreach = (new foreach_loop($switch))->display();
		$for = (new for_loop($foreach))->display();
		$while = (new while_loop($for))->display();

		$this->file_content = $while;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}