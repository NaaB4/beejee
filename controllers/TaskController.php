<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\{Tasks, Users};
use app\components\Request;
use app\components\widgets\Pagination;

class TaskController extends BaseController {

	protected $template;

	public function actionIndex() {
		$model = new Tasks;
		
		$isTaskAdded = $_SESSION["taskAdded"] ?? false;
		if($isTaskAdded) unset($_SESSION["taskAdded"]);

		$request = new Request;
		$get = $request->get();


		$tasks = $this->_t->renderPartial("tasks", $model->getTasks());
		$content = $this->_t->renderPartial("index", compact('tasks', 'isTaskAdded'));
		return $this->_t->render(compact('content'));
	}

	private function getMenu() {

	}

	public function actionAdd() {

		$this->_t->setTitle("добавить задачу");
		$model = new Tasks;
		$errors = [];
		if($request = $model->load((new Request)->post())) {
			if($model->validate($request)) {
				$model->insertTask($request);
				$_SESSION["taskAdded"] = TASK["msg"]["added"];
				header("Location: /");
			} else {
				$errors = $model->_errors;
			}
		}

		$content = $this->_t->renderPartial("taskForm", compact('errors'));

		return $this->_t->render(compact('content'));
	}

}