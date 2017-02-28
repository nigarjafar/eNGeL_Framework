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
		var_dump($user->find($id)->get());
	}

	public function get_all(){
		$user=$this->model('User');
		$user->setTable('users');
		var_dump($user->all());
	}

	public function get_create(){
		$user=$this->model('User');
		$user->setTable('users');
		$user->create([
			'name'=>'Engel',
			'email'=>'workssccchujjksd'.rand(0,29299292),
			'user_type'=>'company',
			'password'=>'ahuhsujd'
			]);
	}

	public function get_update($id){
		$user=$this->model('User');
		$user->setTable('users');
		$user->find($id)->update([
			'name'=>'EngelFM',
			'user_type'=>'user',
		]);
	
	}

	public function get_delete($id){
			$user=$this->model('User');
			$user->setTable('users');
			$user->delete(["name"=> "Engel"]);

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