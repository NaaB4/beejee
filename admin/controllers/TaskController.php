<?php

namespace admin\controllers;

use app\controllers\BaseController;
use admin\models\Tasks;
use app\models\Users;
use app\components\{Request, Templater};
use app\components\widgets\Pagination;

class TaskController extends BaseController {

	protected $template;

	public function actionIndex() {
		$this->_t = new Templater("Admin");
		$this->_t->setTitle("админка");
		$content = $this->_t->renderPartial("index");
		return $this->_t->render(compact('content'));
	}

	public function actionEdit($page = NULL) {

		$this->_t->setTitle("редактирование задачи #$page");

		if(!Users::isAdmin()) { header("Location: /"); exit(); }
		$isAdmin = true;
		$model = new Tasks;
		$task = $model->getTask($page)[0];

		if(empty($task)) throw new \Exception("Запись не найдена");
		$errors = [];
		if($request = $model->load((new Request)->post())) {
			if($model->validate($request)) {
				$model->updateTask($request, $page);
				$_SESSION["taskAdded"] = TASK["msg"]["edited"];
				header("Location: /");
			} else {
				$errors = $model->_errors;
			}
		}

		$edit = true;

		$content = $this->_t->renderPartial("taskForm", compact('errors', 'task', 'isAdmin', 'edit'));

		return $this->_t->render(compact('content'));
	}


}