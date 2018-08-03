<?php

class if_confition implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	private function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`(if|else\ if)[\ ]{0,}\(([a-zA-Z0-9\_\-\<\>\ \|\&\=\*\!\+\/]+)\)[\ ]{0,}{([^;]+)\}\;`', function ($matches) use (&$file_content) {
			$keyword = $matches[1] === 'else if' ? 'elseif' : $matches[1];
			$condition = $matches[2];
			$new_cond = [];
			$function = $matches[3];

			$function = str_replace("\n", ";\n", $function);

			preg_replace_callback('`([a-zA-Z0-9\<\>\ \=\\\'\"\!]+)`', function($matches) use (&$condition, &$new_cond) {
				$new_cond[] = $matches[1];
			}, $condition);

			foreach ($new_cond as $id => $cond) {
				$new_condition = $cond;
				preg_replace_callback('`([a-zA-Z0-9]+)(==|===|<|>|<=|>=|\!=)([a-zA-Z0-9\\\'\"]+)`', function($part_of_condition) use (&$new_cond, $id) {
					$new_cond[$id] = [
						'old' => $part_of_condition[0],
						'new' => '$'.$part_of_condition[0]
					];
				}, $new_condition);
			}

			foreach ($new_cond as $cond) {
				$condition = str_replace($cond['old'], $cond['new'], $condition);
			}


			$if = '<?php ';
			$if .= $keyword.'(';
			$if .= $condition;
			$if .= ')';
			$if .= ' {';
			$if .= $function;
			$if .= '}';
			$if .= ' ?>';

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