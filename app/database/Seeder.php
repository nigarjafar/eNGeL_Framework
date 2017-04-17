<?php

abstract class Seeder{

	private static $db;
	public static $table;


	public function create($data){
		$con=new DBConnection();
		$db=new DB($con);


		foreach ($data as $key => $datum) {
			$db->insert(static::$table, $datum)->Query();
		}
		return true;
		
	}

	public function delete(){
		$con=new DBConnection();
		$db=new DB($con);

		$db->Delete(static::$table)->Query();

		return true;
		
	}




}