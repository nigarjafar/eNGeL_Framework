<?php

require_once('config.php');



class DB {
	private $con;
	private $where;
	private $columns;
	private $queryStatement;
	private $query;
	private $params;

	public function __construct($con){
		$this->con=$con;
	}

	//Query will be like that: INSERT INTO #table_name (name) VALUES (:name)
	//:name will be replaced actual value in Query.
	public function Create($table,$data){
		$into=null;
		$values=null;
		foreach ($data as $key => $value) {
			$into=$into."`".$key."`";

			$values=$values.":".$key;
			$this->params[":".$key]=$value;


			if (next($data)==true){
				$into=$into.',';
				$values=$values.',';
			}
		}

	$this->queryStatement="INSERT INTO `".$table."` (".$into.") VALUES (".$values.")";

	return $this;

	}

	//UPDATE $table_name SET name=:name
	public function Update($table,$data){
		$key_val=null;
		foreach ($data as $key => $value) {
			$key_val=$key_val.$key."= :".$key;
			$this->params[":".$key]=$value;


			if (next($data)==true){
				$key_val=$key_val.',';
			}
		}

		$this->queryStatement='UPDATE '.$table.' SET '.$key_val.' WHERE '.$this->where;
		return $this;
	}


	//SELECT col_name FROM $table_name WHERE id=:id
	public function Select($table,$col='*'){
		$this->SetColumnsStatement($col);

    	$this->queryStatement = 'SELECT '.$this->columns.' FROM '.$table;
    	$this->queryStatement=is_null($this->where)?$this->queryStatement: $this->queryStatement.' WHERE '.$this->where;
		return $this;
	}

	//DELETE FROM $table_name WHERE id=:id
	public function Delete($table){
		$this->queryStatement= 'DELETE FROM '.$table.' WHERE '.$this->where;
		return $this;
	}

// select NAME,SURNAME, AGE  from where .....
	public function SetColumnsStatement($col){
		$this->columns=is_array($col)?implode(',', $col):$col;
		return $this;
	}

//WHERE 
	public function SetWhereStatement($rows,$operator='AND'){
	
		if(!empty($rows)){
			if(!empty($this->where))
				$this->where=$this->where.' '.$operator.' ';

			foreach ($rows as $row) {
				$this->where=$this->where.$row[0].$row[1].' :'.$row[0];
				$this->params[":".$row[0]]=$row[2];
				if($row!=end($rows))
					$this->where=$this->where.' '.$operator.' ';
				}
		}
		
		return $this;
	}

//Get rows from db
	public function Get(){
		$results = $this->query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

//Sends query
	public function Query(){
	  	var_dump($this->queryStatement);
	  	echo "<hr>";
	  	var_dump($this->params);

        $this->query=$this->con->prepare($this->queryStatement);
           $this->query->execute($this->params);

        //Deleting query statement
		$this->queryStatement=null;
		$this->where=null;
		$this->columns=null;
		$this->params=null;
		return $this;
	}




}




?>