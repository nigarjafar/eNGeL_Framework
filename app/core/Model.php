<?php

class Model{
	protected $db;
	protected $id;
	public $table;
	public $where;
	public function __construct(){
		$con=new DBConnection();
		$this->db=new DB($con);
	}

//function for raw query
	public function rawQuery($query){

        return $this->db->raw($query)->Query()->Get();
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
		$this->db->Update($this->table,$data)->Query();

        return $this;
	}

	//Delete row
	public function delete($where=null,$operator='AND' ){
		
		$this->db->	Delete($this->table)->Query();


		return $this;
	}

	//Return row from DB
	public function get($rows='*'){
		return $this->db->
				Select($this->table,$rows)->Query()->Get();
	}

	public function where(){
		// where ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->db->SetWhereStatement($datum,'AND');
			}
		}

		// where( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=(func_get_args()[1])?func_get_args()[1]:"is null";
			$this->db->SetWhereStatement($datum,'AND');

		}

		//where(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=(func_get_args()[1])?func_get_args()[1]:"is null";

			$this->db->SetWhereStatement($datum,'AND');

		}

		return $this;
	}

	public function orWhere(){
		
		// orWhere ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->db->SetWhereStatement($datum,'OR');
			}
		}

		// orWhere( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=func_get_args()[1];
			$this->db->SetWhereStatement($datum,'OR');

		}

		//orhere(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=func_get_args()[2];

		}

		return $this;
	}

	//whereBetween
	public function whereBetween($col, $from,$to){
		echo "hello between model <hr>";
		$datum[0]=$col;
		$datum[1]=$from;
		$datum[2]=$to;
		$this->db->SetWhereStatement($datum,'AND','between');

		return $this;
	}

	public function whereNotBetween($col, $from,$to){
		echo "hello notbetween model <hr>";
		$datum[0]=$col;
		$datum[1]=$from;
		$datum[2]=$to;
		$this->db->SetWhereStatement($datum,'AND','notBetween');

		return $this;
	}
	public function whereIn($col, $in){
		$datum[0]=$col;
		$datum[1]=$in;
		$this->db->SetWhereStatement($datum,'AND','in');

		return $this;
	}

	public function whereNotIn($col, $in){
		$datum[0]=$col;
		$datum[1]=$in;
		$this->db->SetWhereStatement($datum,'AND','notIn');

		return $this;
	}
	

	public function whereNull($col){
		$datum[0]=$col;
		$this->db->SetWhereStatement($datum,'AND','null');

		return $this;
	}

	public function whereNotNull($col){
		$datum[0]=$col;
		$this->db->SetWhereStatement($datum,'AND','notNull');

		return $this;
	}

	public function whereColumn(){
// whereColumn ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->db->SetWhereStatement($datum,'AND','column');
			}
		}

		// whereColumn( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=func_get_args()[1];
			$this->db->SetWhereStatement($datum,'AND','column');

		}

		//whereColumn(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=func_get_args()[2];
			$this->db->SetWhereStatement($datum,'AND','column');

		}

		return $this;
	}

	public function orderBy($col,$rule){
		$this->db->SetOrderStatement($col,$rule);
		return $this;
	}

	public function inRandomOrder(){
		$this->db->SetOrderStatement(null,"RAND()");
		return $this;
	}

	public function limit($number){
		$this->db->SetLimitStatement($number);
		return $this;
	}

	public function first($rows='*'){
		$this->db->SetLimitStatement(1);
		return $this->db->
				Select($this->table,$rows)->Query()->Get()[0];
	}

	public function offset($number){
		$this->db->SetOffsetStatement($number);
		return $this;
	}

	public function count(){
		return $this->db->
				Select($this->table,"COUNT(*)")->Query()->Get();
	}

	public function max($col){
		return $this->db->
				Select($this->table,"MAX(`".$col."`)")->Query()->Get();
	}
	public function min($col){
		return $this->db->
				Select($this->table,"MIN(`".$col."`)")->Query()->Get();
	}

	public function avg($col){
		return $this->db->
				Select($this->table,"AVG(`".$col."`)")->Query()->Get();
	}

	public function sum($col){
		return $this->db->
				Select($this->table,"SUM(`".$col."`)")->Query()->Get();
	}

	public function distinct(){
		$this->db->SetDistinctStatement();
		return $this;
				
	}


}

	

