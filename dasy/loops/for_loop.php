<?php

class for_loop implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	protected function parse() {
		$file_content = $this->file_content;
		preg_replace_callback('`for\([\ ]{0,}([^\)]+)[\ ]{0,}\)[\ ]{0,}\{([^;]+)\};`', function ($matches) use (&$file_content) {
			$condition = $matches[1];
			preg_replace_callback('`(let|var)[\ ]{0,}([^;]+);[\ ]{0,}([a-zA-Z0-9\ \<\>\=\!\_\&\|]+);[\ ]{0,}([a-zA-Z\+\-\*\/\ \,]+)`', function ($parts) use (&$condition) {
				$var_operator = '$';

				$var_init = $parts[2];
				$var_init_array = explode(', ', $var_init);
				$var_init = '';
				foreach ($var_init_array as $item) {
					$var_init .= $var_operator.$item.', ';
				}
				$var_init.= ';';
				$var_init = str_replace(', ;', '', $var_init);

				$cond = $parts[3];
				preg_replace_callback('`([a-zA-Z0-9\_]+)[\ ]{0,}(<|>|==|===|!=|<=|>=)[\ ]{0,}([a-zA-Z0-9\_]+)`', function ($cond_parts) use (&$cond) {
					$var1 = $cond_parts[1];
					$var2 = $cond_parts[3];
					$operator = $cond_parts[2];

					$cond = str_replace($cond_parts[0], '$'.$var1.' '.$operator.' $'.$var2, $cond);
				}, $cond);

				$action = $parts[4];
				$action = '$'.$action;

				$condition = str_replace($parts[0], $var_init.'; '.$cond.'; '.$action, $condition);

			}, $condition);

			$fonction = $matches[2];
			$fonction = str_replace("\n", ";\n", $fonction);

			$for = '<?php ';
			$for .= 'for(';
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