<?php

namespace app\config;
class db {
	private $db_host = "localhost";
	private $db_user = "beejee";
	private $db_pass = "llhN*myjWS3319]K";
	private $db_name = "t_beejee";


	private $connect;
	private $query;
	private $tableName;
	private $where;

	public function __construct() {
		$this->connect();
	}

	public function connect()
	{
		if($this->connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name)) return $this->connect;
		if (mysqli_connect_errno()) {
			throw new \Exception("Отсутствует подключение к базе данных. " . mysqli_connect_error());
		}
		throw new \Exception("Отсутствует подключение к базе данных. Проверьте данные config/db.php");
		return false;
	}

	public static function init() {
		return new db();
	}

	public function select($query = "*") {
		if(is_array($query)) {
			$a = [];
			if (!isset($query[0])) {
				foreach($query as $key => $value) {
					$a[] = "$key as $value";
				}
			} else $a = $query;
			$this->query = implode(", ", $a);
		} else {
			$this->query = $query;
			$data = $this->getResult($query);
			if(!empty($data)) return $data;
			return false;
		}
		return $this;
	}

	public function from($tableName) {
		$this->tableName = $tableName;
		return $this;
	}

	public function all() {
		$where = $this->where ? " WHERE " . $this->where : "";
		$query = "SELECT " . $this->query . " FROM " . $this->tableName . $where;
		
		$data = $this->getResult($query);
		if(!empty($data)) return $data;
		return false;
	}

	private function getResult($query) {
		$data = [];
		if ($result = $this->connect->query($query)) {
			while( $row = $result->fetch_assoc() ){
				$data[] = $row;
			}
			$result->close();
		}
		return $data;
	}

	public function where($where) {
		if(is_array($where)) {
			$a = [];
			foreach($where as $key => $value) {
				$a[] = "$key='$value'";
			}
			$this->where = implode(" AND ", $a);
		} else {
			$this->where = $where;
		}
		return $this;
	}

	public function insert($tableName, $data) {
		foreach($data as $v) {
			$val[] = "'".str_replace("'", "\'", $v)."'";
		}
		$name = implode(",", array_keys($data));
		$val = implode(", ", $val);
		$query = "INSERT INTO $tableName ($name) VALUES ($val)";
		if(!$this->connect->query($query)) throw new \Exception("Запись не добавлена");
	}

	public function update($tableName, $data, $id) {
		$updateVal = [];
		foreach($data as $k => $v) {
			$updateVal[] = "$k='".str_replace("'", "\'", $v)."'";
		}

		$updateVal = implode(", ", $updateVal);
		$query = "UPDATE $tableName SET $updateVal WHERE id = $id";
		if(!$this->connect->query($query)) throw new \Exception("Запись не обновлена");
	}

	public function count($tableName) {
		$query = "SELECT count(id) as count FROM $tableName";
		$s = $this->connect->query($query);
		return $s->fetch_object()->count;
	}
}