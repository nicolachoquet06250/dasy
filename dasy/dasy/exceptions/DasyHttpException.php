<?php

class DasyHttpException extends Exception implements Throwable {
	private $params = [];

	public function set_params($params) {
		$this->params = $params;
	}

	public function get_params() {
		return $this->params;
	}
}