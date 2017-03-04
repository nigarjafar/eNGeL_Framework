<?php

class Model{
	protected $db;
	protected $id;
	public $table;
	public $where;
	public $orWhere;
	public function __construct(){
		$con=new DBConnection();
		$this->db=new DB($con);
	}

	public function setTable($table){
		$this->table=$table;
	}

	public function all($rows='*'){
		return $this->db->Select($this->table,$rows)->Query()->Get();
	}

	//Create new
	public function create($data){
		return $this->db->Create($this->table, $data)->Query();
	}

	//Update row
	public function update($data){
		$this->db->SetWhereStatement($this->where,'AND')->
        		SetWhereStatement($this->orWhere,'OR')->
        		Update($this->table,$data)->Query();

        return $this;
	}

	//Delete row
	public function delete($where=null,$operator='AND' ){
		
		$this->db->SetWhereStatement($this->where,'AND')->
        			SetWhereStatement($this->orWhere,'OR')->
        			Delete($this->table)->Query();


		return $this;
	}

	//Return row from DB
	public function get($rows='*'){
		echo "AND" ;print_r($this->where);
		echo "OR"; print_r($this->orWhere);
		return $this->db->
				SetWhereStatement($this->where,'AND')->
				SetWhereStatement($this->orWhere,'OR')->
				Select($this->table,$rows)->Query()->Get();
	}

	public function where(){
		print_r(func_num_args());
		echo "<hr>";
		print_r(func_get_args());
		echo "<hr>";

		// where ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->where[count($this->where)]=$datum;
			}
		}

		// where( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=func_get_args()[1];
			$this->where[count($this->where)]=$datum;
		}

		//where(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=func_get_args()[2];
			$this->where[count($this->where)]=$datum;
		}

		return $this;
	}

	public function orWhere(){
		
		// orWhere ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->orWhere[count($this->orWhere)]=$datum;
			}
		}

		// orWhere( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=func_get_args()[1];
			$this->orWhere[count($this->orWhere)]=$datum;
		}

		//orhere(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=func_get_args()[2];
			$this->orWhere[count($this->orWhere)]=$datum;
		}

		return $this;
	}
}

	

