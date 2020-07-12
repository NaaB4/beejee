<?php

namespace app\controllers;

use app\components\Templater;

class BaseController {

	protected $errors;

	// Templater $_t
	protected $_t;

	public function __construct($template, $action,$page = NULL) {
		$this->_t = new Templater($template);
		if(method_exists($this, $action)) {
			return $this->$action($page);
		} else {
			throw new \Exception("Не найдено действие <i>{$template}Controller <b>$action</b></i>");
		}
	}


	public function __get($name) {
		if (isset($this->$name)) return $this->$name;
	}

}