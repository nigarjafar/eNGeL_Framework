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

	public function all(){
		
	}



}