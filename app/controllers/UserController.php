<?php

class UserController extends Controller{

    public $session;

    function __construct()
    {
       $this->session = $this->loadLib('Session');
    }


    public function index(){
		echo "Hello index user";
    // $string=word_limiter("    LaleMemmedova  ",'7');
    $string=strmb();
		return $this->View('home', ['string'=>$string]);
		// return $this->View('post');

	}


	public function get_message(){
		$user=$this->model('User');
        $user->username="Nigar";

        if ($user->username!="Nigar"){
//            $this->session->setSession('danger', 'girish qadagan');
        }

        return $this->View('home', ['name'=>$user->username]);

	}

	public function get_profile(){
		$user=$this->model('User');
		$user->setTable('users');

		$user=$user->distinct()->get();
		var_dump($user);
		
		//var_dump($user->where('name','Engel')->whereBetween('id',1,10)->get(['id','name']));
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
			'password'=>'ahuhsujd'.rand(0,29299292)
			
			]);
	}

	public function get_update($id){
		$user=$this->model('User');
		$user->setTable('users');
		$user->where("id",$id)->update([
			'name'=>'EngelFM',
			'user_type'=>'user',
		]);

	}

	public function get_delete($id){
			$user=$this->model('User');
			$user->setTable('users');
			$user->where("id",$id)->delete(["name"=> "Engel"]);

	}	

	public function get_where($id){
			$user=$this->model('User');
			$user->setTable('users');
			var_dump($user->where(	"id",">",$id)->where('name','=','Nigar')->get());

	}
	public function get_orwhere($id){
			echo "hello";
			$user=$this->model('User');
			$user->setTable('users');
			var_dump($user->where("user_type","user")
						->where("password",'ahuhsujd')
							->orWhere("id",">",$id)
							->orWhere('name','=','Nigar')
							->get());


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
		$config['input_name']='file_name';
		$config['submit_name']='submit';
		$config['upload_path']= 'uploads/';
		$config['max_size'] = '100';
		$config['allowed_types'] = 'jpeg|jpg|png|gif';
		$result=$this->upload($config);
		return $this->View('upload', ['file'=>$result]);
		//  $this->View('post',$config);


	}

}
