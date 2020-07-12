<?php

namespace app\models;

use app\models\BaseModel;
use app\components\widgets\Pagination;

class Tasks extends BaseModel {

	private $tableName = "tasks";

	protected function rules() {
		return [
			'name' => ['required', 'minLen' => 3,'maxLen' => 150],
			'email' => ['required', 'email'],
			'text' => ['required', 'minLen' => 5],
			'completed' => ['null'],
			'modified' => ['null'],
		];
	}


	public function insertTask($data) {
		$db = $this->db()->insert($this->tableName, $data);

	}

	public function getTasks() {
		$db = $this->db();

		$pagination = Pagination::init();
		$pagination->setTotalCount($db->count($this->tableName));

		$tasks = $db 
		->select("
			SELECT * 
			FROM {$this->tableName} 
			ORDER BY {$pagination->getOrder()} 
			LIMIT {$pagination->getLimit()}
			");

		if(empty($tasks)) {
			// throw new \Exception("Ошибка в запросе " . __FILE__);
		}

		$paginationHtml = $pagination->render();
		return compact('tasks', 'paginationHtml');
	}

	public function getTask($id) {
		$db = $this->db();

		$task = $db 
		->select("
			SELECT * 
			FROM {$this->tableName} 
			WHERE id = '$id'
			");

		return $task;
	}

	public function updateTask($data, $id) {
		$task = $this->getTask($id)[0];
		if($task["text"] != $data["text"]) {
			$data["modified"] = 1; 
		}
		$data["completed"] = isset($data["completed"]) ? 1 : 0;
		$db = $this->db()->update($this->tableName, $data, $id);
	}

	public function changeTaskStatus($id, $status) {
		$data = ["completed" => $status];
		$db = $this->db()->update($this->tableName, $data, $id);
	}

}