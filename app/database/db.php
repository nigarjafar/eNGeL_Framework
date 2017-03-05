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

	//raw function
	public function raw($ne){
        $this->queryStatement=$ne;
        return $this;
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

	$this->queryStatement="INSERT INTO `".$table."` (".$into.") VALUES (".$values.")";

	return $this;

	}

	public function Update($table,$data,$where,$operator='AND'){
		$this->SetWhereStatement($where,$operator);

		$key_val=null;
		foreach ($data as $key => $value) {
			$key_val=$key_val.$key."='".$value."'";


			if (next($data)==true){
				$key_val=$key_val.',';
			}
		}

		$this->queryStatement='UPDATE '.$table.' SET '.$key_val.' WHERE '.$this->where;
		return $this;
	}

//////////nigar burda where-a null beraber etdim. cunku where yazmasan error verirdi. null yazdim sakit dursun. 'gunel'
	public function Select($table,$col='*',$where,$operator='AND'){
		$this->SetWhereStatement($where);
		$this->SetColumnsStatement($col);

    	$this->queryStatement = 'SELECT '.$this->columns.' FROM '.$table;
    	$this->queryStatement=is_null($this->where)?$this->queryStatement: $this->queryStatement.' WHERE '.$this->where;
		return $this;
	}

	public function Delete($table,$where,$operator='AND'){
		$this->SetWhereStatement($where);
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

		foreach ($rows as $key => $value) {
			$this->where=$this->where.$key.'= "'.$value.'"';
			if($value!=end($rows))
				$this->where=$this->where.' AND ';
		}
		return $this;
	}



//Get rows from db
	public function Get(){
		$results = $this->query->fetchAll(PDO::FETCH_ASSOC);
		//$results = $this->query->fetch(PDO::FETCH_ASSOC);
		return $results;
	}

//Sends query
//burada prepare execute elave etdikde sql injection-larin qabagin alir;
	public function Query(){
	    //echo "db query";
		//return $this->queryStatement;
        var_dump($this->queryStatement);
//    echo $_POST['first'];
//        $this->query = $this->con->prepare($this->queryStatement);
//        $this->query->bindValue(':name', $_POST['first']);
//        $this->query->execute();
		$this->queryStatement=null;
		$this->where=null;
		$this->columns=null;
		return $this;
	}


}




?>