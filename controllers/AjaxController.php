<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\{Tasks, Users};
use app\components\Request;

class AjaxController extends BaseController{

	public function actionNewTask() {

		$model = new Tasks;
		$errors = [];
		$data = [];

		if($request = $model->load((new Request)->post())) {
			if($model->validate($request)) {
				$model->insertTask($request);
				$_SESSION["taskAdded"] = TASK["msg"]["added"];
				$data["status"] = true;
			} else {
				$errors = $model->_errors;
				$data["status"] = false;
				$data["errors"] = $errors;
			}
		}
		echo json_encode($data);
	}

	public function actionEditTask($page) {
		$data = [];
		if(!Users::isAdmin()) {
			$data["status"] = false;
			$data["redirect"] = "/user/login";
		} else { 

			$model = new Tasks;
			$task = $model->getTask($page)[0];
			$errors = [];
			if($request = $model->load((new Request)->post())) {
				if($model->validate($request)) {
					$model->updateTask($request, $page);
					$data["status"] = true;
					$data["notRedirect"] = true;
					$data["message"] = TASK["msg"]["edited"];
				} else {
					$errors = $model->_errors;
					$data["status"] = false;
					$data["errors"] = $errors;
				}
			}
		}
		echo json_encode($data);
	}

	public function actionLogin() {
		$model = new Users;
		$data = [];
		if($model::isLogin()) {  
			$data["status"] = false;
			$data["isUser"] = true;
		} else {
			$errors = [];
			$data = [];

			if($request = $model->load((new Request)->post())) {
				if($model->validate($request) && $model->auth($request)) {
					$data["status"] = true;
				} else {
					$errors = $model->_errors;
					$data["status"] = false;
					$data["errors"] = $errors;
				}
			}
		}
		echo json_encode($data);
	}

	public function actionChangeTaskStatus($id) {
		
		$data = [];
		if(!empty($id)) {
			$model = new Tasks;
			$request = (new Request)->post();
			$newStatus = $request["status"] == 1 ? 0 : 1;
			$model->changeTaskStatus($id, $newStatus);
			$data["message"] = TASK["msg"]["status_changed"];
			$data["newStatus"] = $newStatus;
			$data["statusIcon"] = $newStatus == 1 ? TASK["icon"]["completed"] : TASK["icon"]["not_completed"];
			$data["statusMessage"] = $newStatus == 1 ? TASK["msg"]["not_completed"] : TASK["msg"]["completed"];
		}
		echo json_encode($data);
	}



}