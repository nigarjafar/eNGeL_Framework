<?php

class Model{
	protected $db;
	protected $id;
	public $table;
	public function __construct(){
		$con=new DBConnection();
		$this->db=new DB($con);
	}

	public function setTable($table){
		$this->table=$table;
	}

	//Set id of Model object. Usa cases: find->get , find->update ; find()->delete();
	public function find($id){
		$this->id=$id;
		return $this;
	}

	public function all($rows='*'){
		return $this->db->Select($this->table,$rows)->Query()->Get();
	}

	//Create new
	public function create($data){
		return $this->db->Create($this->table, $data)->Query();
	}

	//Update row
	public function update($data,$where=null){
		if($where==null){
			$where=["id"=>$this->id];
		}
        $this->db->Update($this->table,$data,$where)->Query();

        return $this;
	}
	//Delete row
	public function delete($where=null ){
		if($where==null)
		{
			$where=["id"=>$this->id];
		}
		$this->db->Delete($this->table, $where,'AND')->Query();

		$this->id=null;

		return $this;
	}

	public function get($rows='*'){
		return $this->db->Select($this->table,$rows,['id'=>$this->id])->Query()->Get()[0];
	}


}