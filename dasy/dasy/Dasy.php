<?php

class Dasy {
	private $directory;
	private static $directory_s;
	private static $params = [];
	public function __construct($directory) {
		$this->set_directory($directory);
	}

	public function set_directory($directory) {
		$this->directory = $directory;
		self::$directory_s = $directory;
	}

	private static function genere_path($file, $directory = '', $force = false) {
		$directory = $directory === '' ? self::$directory_s : $directory;
		return is_file($directory.'/'.$file.'.dasy.php') ? $directory.'/'.$file.'.dasy.php' : ($force ? $directory.'/'.$file.'.dasy.php' : '');
	}

	public static function create($directory = '') {
		return new Dasy($directory);
	}

	public static function assign($var, $value) {
		self::$params[$var] = $value;
	}

	public static function complete_params($params) {
		foreach ($params as $var => $value) {
			self::assign($var, $value);
		}
	}

	public static function get_params() {
		return self::$params;
	}

	public static function get_param($var) {
		return isset(self::$params[$var]) ? self::$params[$var] : null;
	}

	/**
	 * @param       $code
	 * @param array $params
	 * @throws Exception
	 */
	public function make_error($code, $params = []) {
		self::complete_params($params);
		$this->set_directory('dasy/dasy/errors');
		$template = substr($code, 1, strlen($code)-1);

		if (($path = self::genere_path($template)) !== '') {
			dasy_cache::create([
				$path => file_parser::create(php_bloc::get_all($path), $path)->display()
			]);
			foreach ($params as $name => $value) {
				$$name = $value;
			}
			include dasy_cache::get($template);
			dasy_cache::delete($template);
		}
		exit();
	}

	/**
	 * @param string $template
	 * @param array  $params
	 * @throws Exception
	 */
	public function make($template = '', array $params = []) {
		self::complete_params($params);
		if ($_SERVER['REQUEST_URI'] === '/404' || $_SERVER['REQUEST_URI'] === '/500') {
			$this->make_error($_SERVER['REQUEST_URI']);
		}

		if (($path = self::genere_path($template)) !== '') {
			dasy_cache::create([
				$path => file_parser::create(php_bloc::get_all($path), $path)->display()
			]);
			foreach ($params as $name => $value) {
				$$name = $value;
			}
			include dasy_cache::get($template);
			//			dasy_cache::delete($template);
			exit();
		}
		$exept = new DasyHttpException('404 - Le template `'.self::genere_path($template, '', true).'` n\'existe pas');
		$exept->set_params(
			[
				'code' => 404,
				'message' => 'Le template `'.self::genere_path($template, '', true).'` n\'existe pas'
			]
		);
		throw $exept;
	}

}