<?php

class file_parser implements module {
	private $file_content, $php_blocs;
	public function __construct($php_blocs, $file_path = '') {
		$this->file_content = file_get_contents($file_path);
		$this->php_blocs = $php_blocs;
	}

	protected function parse() {
		foreach ($this->php_blocs as $php_bloc) {
//			var_dump($php_bloc);
		}
		$variable = (new variable($this->file_content))->display();
		$constante = (new constante($variable))->display();

		$if = (new if_confition($constante))->display();
		$else = (new else_condition($if))->display();
		$elseif = (new elseif_condition($else))->display();
//		$switch = (new switch_condition($elseif))->display();

//		$foreach = (new foreach_loop($switch))->display();
//		$for = (new for_loop($foreach))->display();
//		$while = (new while_loop($for))->display();

		$while = $elseif;
		var_dump($while);
		$this->file_content = $while;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}