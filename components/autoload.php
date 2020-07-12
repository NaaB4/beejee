<?php

spl_autoload_register(function ($class) {
	if($class != "app\Exception") {
		$class = str_replace(["app\\", "\\"], ["", "/"], $class);
		$path = $_SERVER['DOCUMENT_ROOT'] . '/' . $class . '.php';
		if(is_file($path)) {
			include $path;
		} else {
			throw new \Exception("Класс не найден: " . $class);
		}
	}
});