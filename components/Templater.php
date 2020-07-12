<?php

namespace app\components;

class Templater {

	private $_template;

	public $_title;

	public function __construct($template) {
		$this->_template = $template;
	}

	public function render($params) {

		if(!empty($params))
			extract($params, EXTR_PREFIX_SAME, "wddx");

		$title = $this->_title ?? "задачник";

		$path = $_SERVER["DOCUMENT_ROOT"] . "/views/layout/main.html.php";
		if(is_file($path))
		{
			include $path;
		} else {
			throw new \Exception("Не найден шаблон $path");
		}
	}

	public function renderPartial($layout, $params = NULL) {

		if(!empty($params))
			extract($params, EXTR_PREFIX_SAME, "wddx");

		$path = $_SERVER["DOCUMENT_ROOT"] . "/views/".$this->_template."/".$layout.".html.php";
		if(is_file($path))
		{
			ob_start();
			include  $path;
			$content = ob_get_contents(); 
			ob_end_clean();
		} else {
			throw new \Exception("Не найден макет $path");
		}
		return $content;
	}

	public function setTitle($title) {
			$this->_title = $title;
	}

}