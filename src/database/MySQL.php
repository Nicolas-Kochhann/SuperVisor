<?php

namespace Src\database;

require __DIR__."/../../vendor/autoload.php";
require __DIR__."/../../config/database.php";

use mysqli;

class MySQL{
	
	private $connection;
	
	public function __construct(){
		$this->connection = new mysqli(HOST,USUARIO,SENHA,BANCO);
		$this->connection->set_charset("utf8");
	}

	public function executa($sql){
		$result = $this->connection->query($sql);
		return $result;
	}
	public function consulta($sql){
		$result = $this->connection->query($sql);
		$item = array();
		$data = array();
		while($item = mysqli_fetch_array($result)){
			$data[] = $item;
		}
		return $data;
	}

	public function getUltimoIdInserido(): int{
		return $this->connection->insert_id;
	}

}

