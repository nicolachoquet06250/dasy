<?php

class dump implements module {

	private $file_content;
	private function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public static function create($file_content) {
		return new dump($file_content);
	}

	private function parse() {
		$file_content = $this->file_content;
		preg_replace_callback('`dump[\ ]{0,}\([\ ]{0,}([a-zA-Z0-9\_\ \<\>\=\!\+\-\&\|]+)[\ ]{0,}\);`', function ($matches) use (&$file_content) {
			$expression = $matches[1];
			$operators = [
				'<',
				'>',
				'<=',
				'>=',
				'!=',
				'!==',
				'==',
				'===',
				'&&',
				'||',
			];
			$variable = true;
			foreach ($operators as $operator) {
				if(strstr($expression, $operator)) {
					$variable = false;
					break;
				}
			}
			if(!$variable) {
				preg_replace_callback('`([a-zA-Z0-9\_\ \<\>\=\!\+\-]+)[\ ]{0,}([&&|\|\|]{0,2})`', function ($matches) use (&$expression) {
					$local_expression = $matches[1];
					$separator = $matches[2];

					preg_replace_callback('`([a-zA-Z0-9\_]+)[\ ]{0,}(===|==|!==|!=|<=|>=|<|>)[\ ]{0,}([a-zA-Z0-9\_]+)`', function ($matches) use (&$local_expression) {
						$var1 = $matches[1];
						$var2 = $matches[3];
						$operator = $matches[2];

						$local_expression = str_replace($matches[0], '$'.$var1.' '.$operator.' $'.$var2, $local_expression);
					}, $local_expression);

					$expression = str_replace($matches[0], $local_expression.' '.$separator, $expression);
				}, $expression);
			}
			else {
				$expression = '$'.$expression;
			}
			$file_content = str_replace($matches[0], '<?php var_dump('.$expression.'); ?>', $file_content);
		}, $file_content);

		preg_replace_callback('`dump_constant[\ ]{0,}\([\ ]{0,}([a-zA-Z0-9\_]+)[\ ]{0,}\);`', function ($matches) use (&$file_content) {
			$variable = $matches[1];
			$file_content = str_replace($matches[0], '<?php var_dump('.$variable.'); ?>', $file_content);
		}, $file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}