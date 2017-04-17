<?php

require_once('config.php');



class DB {
	private $con;
	private $where=null;
	private $columns=null;
	private $queryStatement=null;
	private $query=null;
	private $params=array();
	private $order=null;
	private $limit=null;
	private $offset=null;
	private $distinct=null;
	private $foreignKeys=null;
	private $join=array();

	public function __construct($con){
		$this->con=$con;
	}


	//raw function
	public function raw($query,$params=null){
        $this->queryStatement=$query;
        if($params)
        	$this->params=$params;
        return $this;
    }

    public function CreateTable($table_name, $data){
    	$this->queryStatement="CREATE TABLE ".$table_name."(";
    	var_dump($data);
    	foreach ($data as $key => $value) {
    		$this->queryStatement.=$key." ".$value;

    		if (next($data)==true){
				$this->queryStatement.=',';
			}
    	}

        $this->queryStatement.=$this->foreignKeys.')';

        return $this;
    }

	//Query will be like that: INSERT INTO #table_name (name) VALUES (:name)
	//:name will be replaced actual value in Query.

	public function Insert($table,$data){
		$into=null;
		$values=null;
		foreach ($data as $key => $value) {
			$into=$into."`".$key."`";
			echo "$key";
			$values=$values.":".$key;
			$this->params[":".$key]=$value;


			if (next($data)==true){
				$into=$into.',';
				$values=$values.',';
			}
		}
		// Check if created_at column exist or not

		$existCreated_at = $this->con->query("SHOW COLUMNS FROM ".$table." LIKE 'created_at'")->rowCount();
		if($existCreated_at)
		  	$this->queryStatement="INSERT INTO `".$table."` (".$into." ,created_at) VALUES (".$values." ,NOW())";
		else
			$this->queryStatement="INSERT INTO `".$table."` (".$into." ) VALUES (".$values.")";

		return $this;

	}

	//UPDATE $table_name SET name=:name
	public function Update($table,$data){
		echo "hello update <hr>";
		$key_val=null;


		$keys = array_keys($data);

		for($i=0; $i < count($keys); $i++) {
		    $key_val.="`".$keys[$i]."` = ?";
		 	array_unshift($this->params,$data[$keys[ count($keys)-$i-1]]);

		 	if($i!=count($keys)-1)
		 		$key_val.=', ';
		}
		
		$this->queryStatement='UPDATE '.$table.' SET '.$key_val.' WHERE '.$this->where;
		return $this;
	}


	public function Select($table,$col='*'){
		$this->SetColumnsStatement($col);
		

    	$this->queryStatement = 'SELECT '.$this->distinct." ".$this->columns.' FROM '.$table." ".
    							implode(" ", $this->join)." ".
    							((is_null($this->where)) ? null : ' WHERE '.$this->where." ").
    							$this->order." ".
    							$this->limit." ".
    							$this->offset;
    	
		return $this;
	}

	//DELETE FROM $table_name WHERE id=:id ...
	public function Delete($table){
		$this->queryStatement= 'DELETE FROM `'.$table.((is_null($this->where)) ? null : ' WHERE '.$this->where." ");
		return $this;
	}


	// Soft Delete
	public function SoftDelete($table){
		$this->queryStatement= 'UPDATE '.$table.' SET `deleted_at`=NOW() WHERE '.$this->where;
		return $this;
	}

// select NAME,SURNAME, AGE  from where .....
	public function SetColumnsStatement($col){
		$this->columns=is_array($col)?implode(',', $col):$col;
		return $this;
	}

//WHERE 
	public function SetWhereStatement($row,$operator='AND', $helperOperator=null){
		echo "hello where <hr>";
		if(!empty($row)){
			
				if(!empty($this->where))
					$this->where=$this->where.' '.$operator.' ';

				if($helperOperator){
					$this->SetHelperWhereStatement($row, $helperOperator);
				}
				else{
					$this->where.="`".$row[0]."`".$row[1].' ?';
					array_push($this->params,$row[2]);
				}

				
		}
		
		return $this;
	}

	public function SetHelperWhereStatement($row, $helperOperator){
		echo "Hello helper <hr>";
		switch ($helperOperator) {
			case 'between':
				//WHERE `colname` BETWEEN :from_colname AND :to_colname"
				$this->where.=' `'.$row[0].'` BETWEEN ? AND ?';
				$this->params[count($this->params)]=$row[1];
				$this->params[count($this->params)]=$row[2];
				break;

			case 'notBetween':
				//WHERE `colname` NOT BETWEEN :from_colname AND :to_colname"
				$this->where.=' `'.$row[0].'`NOT BETWEEN ? AND ?';
				$this->params[count($this->params)]=$row[1];
				$this->params[count($this->params)]=$row[2];
				break;

			case 'in':

				//WHERE `colname` IN (?,?,?,....?)
				$this->where.=' `'.$row[0].'` IN (';

				foreach ($row[1] as $key => $value) {
					$this->where.='?';
					$this->params[count($this->params)]=$value;

					if (next($row[1])==true) 
						$this->where.= ",";
				}

				$this->where.=')';
				break;

			case 'notIn':
					//WHERE `colname` NOT BETWEEN :from_colname AND :to_colname"
					$this->where.=' `'.$row[0].'`NOT IN (';

					foreach ($row[1] as $key => $value) {
						$this->where.='?';
						$this->params[count($this->params)]=$value;

						if (next($row[1])==true) 
							$this->where.= ",";
					}

					$this->where.=')';
					break;
			case 'null':
				$this->where.=$row[0].' IS NULL';
				break;
			case 'notNull':
				$this->where.=$row[0].' IS NOT NULL';
				break;

			case 'column':
				$this->where.='`'.$row[0].'`'.$row[1].'`'.$row[2].'`';
				break;
				

			default:
				break;
		}
	}

	// Set Join statement and add the join array
	public function SetJoinStatement($joinType,$table,$baseTableCol=null,$operator=null,$joinTableCol=null){
		if($joinType=="CROSS"){
			array_push($this->join,$joinType." JOIN ".$table);
		}
		else{
			array_push($this->join,$joinType." JOIN ".$table." ON ".$baseTableCol." ".$operator." ".$joinTableCol);
		}
		return $this;
	}

	public function SetOrderStatement($col, $rule){
		
		$this->order.="ORDER BY ".(($col) ? ("`".$col."` ".$rule) : $rule);
		return $this;
	}

	public function SetLimitStatement($number){
		$this->limit.='LIMIT '.$number;
		return $this;
	}
	
	public function SetOffsetStatement($number){
		$this->offset.='OFFSET '.$number;
		return $this;
	}

	public function SetDistinctStatement(){
		$this->distinct="DISTINCT";
		return $this;
	}

//Get rows from db
	public function Get(){
		$results = $this->query->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}
//Get rows from db
	public function RowCount(){
		$results = $this->query->rowCount();
		return $results;
	}


//Add foreign key
	public function AddForeignKey($col, $referenceTable, $referenceCol){
		$this->foreignKeys.=', Foreign Key ('.$col.') REFERENCES '.$referenceTable.'('.$referenceCol.')' ;
		return $this;
	}

//Sends query
//burada prepare execute elave etdikde sql injection-larin qabagin alir;
	public function Query(){
	  	var_dump($this->queryStatement);
	  	echo "<hr>Params:";
	  	var_dump($this->params);
	  	echo "<hr>";

        $this->query=$this->con->prepare($this->queryStatement);
        $this->query->execute($this->params);

        //Deleting query statement and data
		$where=null;
		$columns=null;
		$queryStatement=null;
		$query=null;
		$params=array();
		$order=null;
		$limit=null;
		$offset=null;
		$distinct=null;
		$foreignKeys=null;
		$join=array();
		return $this;


	}




}




?>