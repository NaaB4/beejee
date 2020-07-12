<?php

namespace admin\models;

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


	public function updateTask($data, $id) {

		$task = $this->getTask($id)[0];

		if($task["text"] != $data["text"]) {
			$data["modified"] = 1; 
		}

		$data["completed"] = isset($data["completed"]) ? 1 : 0;

		$db = $this->db()->update($this->tableName, $data, $id);

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

}