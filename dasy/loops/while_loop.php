<?php

class while_loop implements module {

	private $file_content;
	private function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public static function create($file_content) {
		return new while_loop($file_content);
	}

	protected function parse() {
		$file_content = $this->file_content;
		preg_replace_callback('`while[\ ]{0,}\([\ ]{0,}([a-zA-Z0-9\_\<\>\!\=\&\|\ ]+)\)[\ ]{0,}\{([^;]+)\};`', function ($matches) use (&$file_content) {
			$condition = $matches[1];
			preg_replace_callback('`([a-zA-Z0-9\_]+)[\ ]{0,}(>=|<=|==|===|!=|!==|<|>)[\ ]{0,}([a-zA-Z0-9\_]+)`', function ($cond_parts) use (&$condition) {
				$operator = $cond_parts[2];
				$var1 = '$'.$cond_parts[1];
				$var2 = '$'.$cond_parts[3];

				$condition = str_replace($cond_parts[0], $var1.' '.$operator.' '.$var2, $condition);
			}, $condition);

			$fonction = $matches[2];
			$fonction = str_replace("\n", ";\n", $fonction);

			$for = '<?php ';
			$for .= 'while(';
			$for .= $condition;
			$for .= ')';
			$for .= ' {';
			$for .= $fonction;
			$for .= '}';
			$for .= ' ?>';
			$for = str_replace('{;', '{', $for);

			$file_content = str_replace($matches[0], $for, $file_content);
		}, $this->file_content);
		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}