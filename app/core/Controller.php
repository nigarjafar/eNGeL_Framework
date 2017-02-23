<?php

class Controller{

	public function model($model){
		require_once '../app/models/'.$model.'.php';
		return new $model;
	}
	
	public function View($url, $data=[]){
		require_once '../app/views/'.$url.'.php';
	}

	// public function DB($table){
	// 	require_once '../app/database/db.php';
	// 	return new db($table,new DBConnection());
	// }
}