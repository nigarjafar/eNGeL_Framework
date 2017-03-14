<?php


class Table{
	private $table_name;
	private $columns;
	private $db;


	

	function __construct($table_name){
		$this->table_name=$table_name;

		$con=new DBConnection();
		$this->db=new DB($con);
	}


	function addColumn($column_name, $column_type){
		$columns["$column_name"]=$column_type;
		return $this;
	}


	function save(){
		$this->db->CreateTable($this->table_name,$this->columns)->Query();
		return $this;
	}


}