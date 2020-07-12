<?php

namespace app\models;

use app\config\db;
use app\components\Validator;

abstract class BaseModel {

	abstract protected function rules();

	protected $_errors = [];
	protected $_request = [];

	public function db() {
		return db::init();
	}

	public function validate($data) {
		$v = new Validator();
		$isValid = $v->validate($data, $this->rules());
		$this->_errors = ($v->getErrors());
		return $isValid;
	}

	public function __get($name) {
		if (isset($this->$name)) return $this->$name;
	}

	public function load($request) {
		$rules = $this->rules();

		if($rules) {
			$keys = array_flip(array_keys($this->rules()));
			$return = array_intersect_key($request, $keys);
			if(!empty($return)) return $return;
		}
		return false;
	}

}