<?php

class UserController extends Controller{

	public function index(){
		echo "Hello index user";
	}

	public function get_message(){
		$user=$this->model('User');
		$user->username="Nigar";
		return $this->View('home', ['name'=>$user->username]);

	}

	public function get_profile($id){
		$user=$this->model('User');
		$user->setTable('users');
		var_dump($user->getUserById($id));
	}
	public function get_param( $id){
		echo $id;
	}

	public function get_test(){
		echo "It works (GET)";
	}

	public function post_test(){
		echo "It works (POST)";
	}

	public function put_test(){
		echo "It works (PUT)";
	}

	public function delete_test(){
		echo "It works (Delete)";
	}





}