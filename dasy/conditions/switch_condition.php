<?php

class switch_condition implements module {

	private $file_content;
	public function __construct($file_content) {
		$this->file_content = $file_content;
	}

	public function switch_case($content) {
		preg_replace_callback('`case ([a-zA-Z0-9\|\&\_\-\+\*\/\\\'\"]+)[\ ]{0,}(\{)([^\}]+)(\})`', function ($matches) use (&$content) {
			$condition = $matches[1];
			$fonction = $matches[3];
			$fonction = str_replace("\n", ";\n", $fonction);
			$content = str_replace($matches[0], 'case '.$condition.':'.$fonction, $content);
			$content = str_replace(':;', ':', $content);
		}, $content);
		return $content;
	}

	public function switch_default($content) {
		preg_replace_callback('`default[\ ]{0,}(\{)([^\}]+)(\})`', function ($matches) use (&$content) {
			$fonction = $matches[2];
			$fonction = str_replace("\n", ";\n", $fonction);
			$content = str_replace($matches[0], 'default:'.$fonction, $content);
			$content = str_replace(':;', ':', $content);
		}, $content);
		return $content;
	}

	private function parse() {
		$file_content = $this->file_content;

		preg_replace_callback('`switch\(([a-zA-Z0-9\_\-]+)\)[\ ]{0,}\{([^;]+)\}\;`', function ($matches) use (&$file_content) {
			$var_test = '$'.$matches[1];
			$file_content = str_replace($matches[0], '<?php switch('.$var_test.') {'.$matches[2].'} ?>', $file_content);
			$file_content = $this->switch_case($file_content);
			$file_content = $this->switch_default($file_content);
		}, $file_content);

		$this->file_content = $file_content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}