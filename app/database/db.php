<?php

require_once('config.php');



class DB {
	private $con;
	private $where;
	private $columns;
	private $queryStatement;
	private $query;

	public function __construct($con){
		$this->con=$con;
	}

	public function Create($table,$data){
		$into=null;
		$values=null;
		foreach ($data as $key => $value) {
			$into=$into."`".$key."`";

			$values=$values."'".$value."'";

			if (next($data)==true){
				$into=$into.',';
				$values=$values.',';
			}
		}

	$this->queryStatement="INSERT INTO `".$table."` (".$into.") VALUES (".$values.");SELECT * FROM files WHERE id = SCOPE_IDENTITY()";

	return $this;

	}


	public function Select($table,$col='*'){
		$this->SelectRowStatement($col);

    	$this->queryStatement = 'SELECT '.$this->columns.' FROM '.$table;
    	$this->queryStatement=is_null($this->where)?$this->queryStatement: $this->queryStatement.' WHERE '.$this->where;
		return $this;
	}

// select NAME,SURNAME, AGE  from where .....
	public function SelectRowStatement($col){
		$this->columns=is_array($col)?implode(',', $col):$col;
		return $this;
	}

//WHERE 
	public function SetWhereStatement($rows,$operator){
		foreach ($rows as $key => $value) {
			$this->rows=$this->rows.$key.'='.$value;
			if($value!=end($rows))
				$this->where=$this->rows.' AND ';
		}
		return $this;
	}

	public function Query(){
			$this->query = $this->con->query($this->queryStatement);

			return $this;
	}

	public function GetLastInserted($table){
		$this->queryStatement="SELECT * FROM'.$table.' WHERE id = LAST_INSERTED_ID()";
		return $this->Query()->get();
	}

	public function Get(){
		$results = $this->query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}





}




?>