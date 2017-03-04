<?php

class Controller{

	public function model($model){
		require_once '../app/models/'.$model.'.php';
		return new $model;
	}

	public function View($url, $data=[]){
		require_once '../app/views/'.$url.'.php';
	}


    public function loadLib($name){
	    if (file_exists('../app/library/'.$name.'.php')){
	        require '../app/library/'. $name.'.php';

	        return new $name();
        }
        else{
	        echo $name.' movcud deyil. ';
        }
    }
	// public function DB($table){
	// 	require_once '../app/database/db.php';
	// 	return new db($table,new DBConnection());
	// }

	public function upload($value=[])
	{
			$file=new fileConfig;
			$file->file_upload($value);
	}
}
