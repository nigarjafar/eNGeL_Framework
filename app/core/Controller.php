<?php

class Controller
{

	public function model($model)
	{
		require_once '../app/models/'.$model.'.php';
		return new $model;
	}

	public function View($url, $data=[])
	{
		if ($data!=null)
		{
			extract($data);
		}
	 	require_once '../app/views/'.$url.'.php';
	}

	public function loader()
		{
		  if (file_exists('../app/core/Loader.php'))
			{
		    require '../app/core/Loader.php';
		    return new Loader();
		  }
		}

}
