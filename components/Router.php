<?php

namespace app\components;

class Router {

	private $rawpath;

	private function rules() {
		return [
			"" => "task/index",
		];
	}

	public static function init() {
		return new Router();
	}

	public function __construct() {
		$this->rawpath = $this->getUri();
		$this->run();

	}

	private function getUri() {
		$uri = trim($_SERVER['REQUEST_URI'], "/");
		return $uri;
	}

	private function run() {
		$url = explode("?", $this->rawpath)[0];

		$myRules = $this->rules();
		$url = $myRules[$url] ?? $url;

		$url = explode("/", $url);

		$app = "app";
		if($url[0] == "admin") { 
			array_shift($url); $app = "admin"; 
			if(!isset($url[1])) $url = ["task", "index"];
		} 

		$controllerName = $this->createUrl(($url[0]));
		$controller = "\\$app\controllers\\".$controllerName."Controller" ?? "";

		if(empty($url[1])) $url[1] = "index";
		$action = "action" . $this->createUrl($url[1]);

		$page = $url[2] ?? "";

		try {
			$template = (new $controller($controllerName, $action, $page));
		} catch(\Exception $e) {
			include $_SERVER["DOCUMENT_ROOT"] . "/views/404/404.html.php";
		}
	}

	private function createUrl($name) {
		$action = str_replace("-", "", preg_replace_callback('/(?<=(-))./',
			function ($m) { return strtoupper($m[0]); },
			ucfirst($name)));

		return $action;
	}

}