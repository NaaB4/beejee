<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Users;
use app\components\Request;

class UserController extends BaseController {

	public function actionLogin() {

		$this->_t->setTitle("авторизация");

		$model = new Users;
		if($model::isLogin()) { header("Location: /"); exit(); }

		$errors = [];
		if($request = $model->load((new Request)->post())) {
			if($model->validate($request) && $model->auth($request)) {
				header("Location: /");
				exit();
			} else {
				$errors = $model->_errors;
			}
		}

		$content = $this->_t->renderPartial("loginForm", compact("errors"));
		return $this->_t->render(compact('content'));
	}

	public function actionLogout() {
		if(Users::isLogin()) 
			Users::logout();
		header("Location: /"); exit();
	}

}