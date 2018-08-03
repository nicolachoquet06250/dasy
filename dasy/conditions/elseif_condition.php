<?php

class elseif_condition implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	private function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`else if[\ ]{0,}\(([a-zA-Z0-9\_\-\<\>\ \|\&\=\!\*\+\/]+)\)`', function ($matches) use (&$file_content) {
			$condition = $matches[1];
			$new_cond = [];

			preg_replace_callback('`([a-zA-Z0-9\<\>\ \=\\\'\"\!]+)`', function($matches) use (&$condition, &$new_cond) {
				$new_cond[] = $matches[1];
			}, $condition);

			foreach ($new_cond as $id => $cond) {
				$new_condition = $cond;
				preg_replace_callback('`([a-zA-Z0-9]+)(==|===|<|>|<=|>=|!=)([a-zA-Z0-9\\\'\"]+)`', function($part_of_condition) use (&$new_cond, $id) {
					$new_cond[$id] = [
						'old' => $part_of_condition[0],
						'new' => '$'.$part_of_condition[0]
					];
				}, $new_condition);
			}

			foreach ($new_cond as $cond) {
				$condition = str_replace($cond['old'], $cond['new'], $condition);
			}


			$if = 'elseif(';
			$if .= $condition;
			$if .= ')';

			$file_content = str_replace($matches[0], $if, $file_content);
		}, $this->file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}