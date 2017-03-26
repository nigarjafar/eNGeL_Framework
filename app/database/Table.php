<?php


class Table{
	private $table_name;
	private $columns;
	private $db;
	private $foreignKeys=array();

	//Set the table name and create a DBConnection object to run query
	function __construct($table_name){
		$this->table_name=$table_name;

		$con=new DBConnection();
		$this->db=new DB($con);
	}


	//Add column to $columns array
	function addColumn($column_name, $column_type){
		$this->columns["$column_name"]=$column_type;
		return $this;
	}
	

	//Create id column / Not Null/ Auto Increment/ Primary key
	function id(){
		$this->columns["id"]="INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY";
		return $this;
	}


	//Doesn't allow null values
	function notNull(){
		end($this->columns);         // move the internal pointer to the end of the array
		$lastKey = key($this->columns); //get the last key
		$this->columns[$lastKey].=" NOT NULL";//add not null
		reset($this->columns);	//reset the place of the pointer
		return $this;
	}

	//add primary key constraint
	function primaryKey(){
		end($this->columns);         // move the internal pointer to the end of the array
		$lastKey = key($this->columns); //get the last key
		$this->columns[$lastKey].=" PRIMARY KEY";//add primary key keyword
		reset($this->columns);	//reset the place of the pointer
		return $this;
	}


	//add unique constraint
	function unique(){
		end($this->columns);         // move the internal pointer to the end of the array
		$lastKey = key($this->columns); //get the last key
		$this->columns[$lastKey].=" UNIQUE";//add unique keyword
		reset($this->columns);	//reset the place of the pointer
		return $this;
	}


	//Add auto_increment constraint
	function autoIncrement(){
		end($this->columns);         // move the internal pointer to the end of the array
		$lastKey = key($this->columns); //get the last key
		$this->columns[$lastKey].=" AUTO_INCREMENT";//add unique keyword
		reset($this->columns);	//reset the place of the pointer
		return $this;
	}

	// provide default value
	function defaultValue($value){
		end($this->columns);         // move the internal pointer to the end of the array
		$lastKey = key($this->columns); //get the last key
		$this->columns[$lastKey].=" DEFAULT '".$value."'";//add default keyword
		reset($this->columns);	//reset the place of the pointer
		return $this;
	}

	//Allow null values
	function nullable($value){
		end($this->columns);         // move the internal pointer to the end of the array
		$lastKey = key($this->columns); //get the last key
		$this->columns[$lastKey].=" NULL";//add null keyword
		reset($this->columns);	//reset the place of the pointer
		return $this;
	}

	//Add creating_time and last_updating_time columns
	function timeLog(){
		$this->columns["created_at"]="TIMESTAMP";
		$this->columns["updated_at"]="TIMESTAMP";
		return $this;
	}


	//Add deleted_at column. 
	function softDelete(){
		$this->columns["deleted_at"]="TIMESTAMP";
		return $this;
	}

	//Add foreign key
	function foreignKey($referenceTable,$referenceCol){
		end($this->columns);         // move the internal pointer to the end of the array
		$lastKey = key($this->columns); //get the last key
	
		echo "---------------------".$lastKey."------------------------";
		array_push($this->foreignKeys, [$lastKey,$referenceTable,$referenceCol ]);
		reset($this->columns);	//reset the place of the pointer
		return $this;
	}
	//Send query to db.php
	function save(){
		foreach ($this->foreignKeys as $key=>$value) {
			$this->db->AddForeignKey($value[0],$value[1],$value[2]);
		}
		$this->db->CreateTable($this->table_name,$this->columns)->Query();

		return $this;
	}





}