<?php

class UserController extends Controller{

	public function index(){
		echo "Hello index user";
	}

	public function message(){

		$user=$this->model('User');
		$user->username="Nigar";

		return $this->View('home', ['name'=>$user->username]);

	}
	public function param( $id){
		echo $id;
	}
}