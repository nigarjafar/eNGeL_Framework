<?php

class UserController extends Controller{

    public $session;

    function __construct()
    {
       $this->session = $this->loadLib('Session');
    }


    public function index(){
		echo "Hello index user";
		return $this->View('post');

	}


	public function get_message(){
		$user=$this->model('User');
        $user->username="Nigar";

        if ($user->username!="Nigar"){
//            $this->session->setSession('danger', 'girish qadagan');
        }

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
        if (isset($_POST['submit'])){
            $org = $_POST['first'];
            $user=$this->model('User');
            print_r('<pre>');
            print_r($user->rawQuery("SELECT `id` FROM `nese` WHERE `id` = :name"));
            print_r('</pre>');

        }else{
            echo 'not isset';
        }
	}

	public function put_test(){
        echo "It works (put)";

    }

	public function delete_test(){
		echo "It works (Delete)";
	}

	public function post_file()
	{ 
		$this->upload();
	}

}
