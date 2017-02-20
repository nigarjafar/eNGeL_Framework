<?php

class App{

	protected $parameters=[];
	protected $defaultController= "HomeController";
	protected $defaultMethod="index";

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
		if(isset($url[1])&&method_exists($this->defaultController, $url[1])){
			$this->defaultMethod=$url[1];
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