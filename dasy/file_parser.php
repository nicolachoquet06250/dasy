<?php

class file_parser {
	private $file_content, $php_blocs;

	/**
	 * file_parser constructor.
	 *
	 * @param        $php_blocs
	 * @param string $file_path
	 * @throws Exception
	 */
	private function __construct($php_blocs, $file_path = '') {
		if($file_path === '') {
			throw new Exception('');
		}
		$this->file_content = file_get_contents($file_path);
		$this->php_blocs = $php_blocs;
	}

	/**
	 * @param        $php_blocs
	 * @param string $file_path
	 * @return file_parser
	 * @throws Exception
	 */
	public static function create($php_blocs, $file_path = '') {
		return new file_parser($php_blocs, $file_path);
	}

	private function parse() {
		$content = $this->file_content;
		foreach ($this->php_blocs as $php_bloc) {
			$variable = variable::create($php_bloc[2])->display();
			$constante = constante::create($variable)->display();

			$if = if_condition::create($constante)->display();
			$else = else_condition::create($if)->display();
			$elseif = elseif_condition::create($else)->display();
			$switch = switch_condition::create($elseif)->display();

			$foreach = foreach_loop::create($switch)->display();
			$for = for_loop::create($foreach)->display();
			$while = while_loop::create($for)->display();

			$dump = dump::create($while)->display();

			$content = str_replace($php_bloc[0], $dump, $content);
			$content = str_replace("} ?>\n\t<?php", "\t}\n", $content);
			$content = str_replace("} ?>\n\t\t<?php", "\t\t}\n", $content);
		}
		$this->file_content = $content;
		return $this;
	}

	public function display() {
		return $this->parse()->file_content;
	}
}