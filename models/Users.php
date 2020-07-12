<?php

namespace app\models;

use app\models\BaseModel;

class Users extends BaseModel {

	private $tableName = "users";

	protected function rules() {
		return [
			'name' => ['required'],
			'password' => ['required'],
		];
	}

	public function auth($request) {
		$db = $this->db();
		$name = $request["name"];
		$password = md5($request["password"]);
		$login = $db 
		->select("SELECT name, role FROM {$this->tableName} WHERE name = '$name' AND password = '$password' LIMIT 1");

		if(!$login) {
			$this->_errors["name"] = "Неправильный логин или пароль";
			return false;
		}

		$_SESSION["userName"] = $login[0]["name"];
		$_SESSION["userRole"] = $login[0]["role"];
		return true;
	}

	public static function logout() {
		unset($_SESSION["userName"]);
		unset($_SESSION["userRole"]);
	}

	public static function isLogin() {
		if(isset($_SESSION["userName"])) return true;
		return false;
	}

	public static function isAdmin() {
		if(static::isLogin() && $_SESSION["userRole"] == 1) return true;
		return false;
	}

}