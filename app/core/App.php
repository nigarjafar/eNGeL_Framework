<?php

class App{

	protected $parameters=[];
	protected $defaultController= "HomeController";
	protected $defaultMethod="index";
	protected $requestType;


	public function __construct(){

		//Get URL
		$url=$this->getURL();

		// Checking for the controller
		if(file_exists('../app/controllers/'.$url[0].'Controller.php')){
			$this->defaultController=$url[0].'Controller';
			unset($url[0]);
		}

		//Call the controller
		require_once ('../app/controllers/'.$this->defaultController.'.php');

		//Create instance of controller
		$this->defaultController=new $this->defaultController;


		//Checking for the method
		if(isset($url[1])){

			//Checking for the request method
			$requestType=$_SERVER['REQUEST_METHOD'];
			$method=$url[1];

			switch($requestType){
				case "GET": $method= "get_".$method;
							break;
				case "POST": $method= "post_".$method;
							break;
				case "PUT": $method= "put_".$method;
							break;
				case "DELETE": $method= "delete_".$method;
							break;

			}

			if(method_exists($this->defaultController, $method))
				$this->defaultMethod=$method;
				unset($url[1]);

		}


		//Getting parameters
		$this->parameters = $url ? array_values($url) : [];

		//Call proper function
		call_user_func_array([$this->defaultController,$this->defaultMethod],$this->parameters);

	}

	public function getURL(){

		if( isset($_GET['url'])){
			return $url = explode('/',filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));
		}
	}
}
