<?php

namespace app\components;

class Form {

	private $errors;
	private $task;

	public static function init($errors, $task = NULL) {
		return new Form($errors, $task);
	}

	public function __construct($errors, $task = NULL) {
		$this->errors = $errors;
		$this->task = $task;
	}

	public static function end() {

	}

	public function input(array $params) {
		$params = $this->getParams($params);
		if(!empty($params["name"])) {
			$feedback = $this->feedback($params["feedback"]);
			return <<<HTML
			<label for="{$params['name']}">{$params['label']}</label>
			<input type="{$params['type']}" class="form-control" id="{$params['name']}" name="{$params['name']}" value="{$params['value']}" placeholder="{$params['placeholder']}">
			{$params['feedback']}
HTML;
		}		
	}

	public function textarea(array $params) {
		$params = $this->getParams($params);
		if(!empty($params["name"])) {
			return <<<HTML
			<label for="{$params['name']}">{$params['label']}</label>
			<textarea class="form-control" id="{$params['name']}" name="{$params['name']}" placeholder="{$params['placeholder']}" rows="3">{$params['value']}</textarea>
			{$params['feedback']}
HTML;
		}		
	}

	public function email(array $params) {
		$params = $this->getParams($params);
		if(!empty($params["name"])) {
			$feedback = $this->feedback($params["feedback"]);
			return <<<HTML
			<label for="{$params['name']}">{$params['label']}</label>
			<div class="input-group">
			<div class="input-group-prepend">
			<span class="input-group-text">@</span>
			</div>
			<input type="{$params['type']}" class="form-control" id="{$params['name']}" name="{$params['name']}" value="{$params['value']}" placeholder="{$params['placeholder']}">
			{$params['feedback']}
			</div>
HTML;
		}		
	}

	public function checkbox(array $params) {
		$params = $this->getParams($params);
		if(!empty($params["name"])) {
			$checked = $params["value"] == 1 ? "checked" : "";
			return <<<HTML
			<input type="checkbox" class="form-check-input" name="{$params['name']}" $checked>
			<label class="form-check-label">{$params['label']}</label>
HTML;
		}		
	}

	private function getParams(array $params) {
		$params["name"] = $params["name"] ?? "";
		$params["label"] = $params["label"] ?? "";
		$params["placeholder"] = $params["placeholder"] ?? $params["label"];
		$params["type"] = $params["type"] ?? "text";
		$params["error"] = $params["error"] ?? false;
		$params["feedback"] = $this->feedback($params["name"]);
		$params["value"] = trim($this->task[$params["name"]]) ?? "";
		return $params;
	}

	private function feedback($name) {
		if($name) {
			$feedback = $this->errors[$name] ?? "";
				return <<<HTML
			<div class="invalid-feedback" for="$name" style="display: block; width: 100%;">
			$feedback
			</div>
HTML;
		}
		return NULL;
	}

	public function render() {

	}

}