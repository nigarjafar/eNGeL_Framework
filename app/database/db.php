<?php

require_once('config.php');



class DB {
	private $con;

	public function __construct($con){
		$this->con=$con;
	}

	public function SelectByID($table,$id){
    	$st = $this->con->prepare('SELECT * FROM '.$table.' WHERE id = :id');
    	$st->bindParam(':id', $id);
		$st->execute();
		$results = $st->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}



}




?>