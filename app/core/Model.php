<?php

class Model{
	protected $db;
	public $table;
	public function __construct(){
		$con=new DBConnection();
		$this->db=new DB($con);
	}

	public function setTable($table){
		$this->table=$table;
	}

	public function getById($id,$rows='*'){
		return $this->db->SetWhereStatement(['id'=>$id],'AND')->Select($this->table,$rows)->Query()->Get();
	}

	public function all($rows='*'){
		return $this->db->Select($this->table,$rows)->Query()->Get();
	}

	public function create($data){
		return $this->db->Create($this->table, $data)->Query()->GetLastInserted($this->table);
	}


}