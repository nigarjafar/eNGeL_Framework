<?php

class App{

	public function __construct(){
	 	$url=$_GET['url'];

	 	$requestType=$_SERVER['REQUEST_METHOD'];

	 	//Get the proper function[$controller,$method]
		$function=Route::call($url,$requestType);

		
		if($function){
			require_once ('../app/controllers/'.$function[0].'.php');
			$controller=new $function[0];

			//Getting parameters
			$method=$function[1];
			if($function[2])
				$parameters=$function[2];
			else
				$parameters=array();

			//Call proper function
		 	call_user_func_array([$controller,$method],$parameters);
		}
		else
			echo "<h1>Error 404 - Page not found</h1>";
	}

}
