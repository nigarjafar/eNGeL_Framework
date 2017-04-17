<?php

class UserController extends Controller{

 	private $session;
    private $valid;
    private $enc;
    private $parse;

    function __construct()
    {
        $loader= self::loader();

        $this->session=$loader->library('Session');
        $this->valid=$loader->library('Validation');
        $this->enc=$loader->library('Encryption');
        $this->parse=$loader->library('Parser');
    }


    public function index(){

        echo "Hello index user";
    $this->loader()->helper('text');
    $string=word_limiter("    LaleMemmedova  ",'7');

    // $string=strmb();
		// return $this->View('home', ['string'=>$string]);
		return $this->View('post');
	}
	public function get_message($message=null){
		$user=$this->model('User');
        $user->username="Gunel";
        if ($user->username!="Gunel"){
//            $this->session->setSession('danger', 'girish qadagan');
        }
        $parsed = $this->parse->setOutPut('https://www.google.az/');
        var_dump($parsed);
        return $this->View('home', ['name'=>$user->username]);
	}

	public function paginate(){
		$posts=$this->model('Post');
		$posts=$posts->where('id','>',6)->paginate(6);
		//var_dump($posts);
		return $this->View('pagination', ['posts'=>$posts]);
	}

	public function get_profile(){
		$user=$this->model('User');


		$user=$user->max('id');
		var_dump($user);
		// echo "<hr>";
		// echo $user->id;
		// echo "<hr>";
		// var_dump($user->companies());
		//var_dump($user->where('name','Engel')->whereBetween('id',1,10)->get(['id','name']));
	}

	public function get_company(){
		$country=$this->model('Country')->where('id','2')->first();
		echo $country->id."***********";
		$posts=$country->posts();
		echo "<hr>";
		var_dump($posts);
	}
	public function get_raw(){
		echo "Hello";
		$users =DBraw::select("SELECT * FROM users where id=:id",['id'=>2]);
		var_dump($users);

	}

	public function get_all(){
		$user=$this->model('User');
		var_dump($user->where('id','>',0)->get());
		
	}

	public function get_create(){
		$user=$this->model('Comment');
		var_dump($user->create([
			'surname'=>'Engel',



			])
			);
	}

	public function get_update($id){
		$user=$this->model('Comment');
		$user=$user->withTrash()->where("id",$id)->update([
			'surname'=>'EngelklFM',
		]);

		var_dump($user);

	}

	public function get_delete($id){
			$user=$this->model('Comment');
			var_dump($user->where("id",$id)->forceDelete());

	}

	public function get_join(){
			$user=$this->model('User');
			$user->setTable('users');
			$user=$user->leftJoin('companies','users.id','=','companies.user_id')
            	
            	->get();
			var_dump($user);

	}

	public function get_model(){
			echo "<hr><hr><hr><hr><hr>";
			$user=$this->model('User');
			$user= $user->where('id','>',7)->first();
			var_dump($user);
		
	}

	public function get_recover($id){
			$user=$this->model('User');
			$user->setTable('users');
			$user->where("id",'>',0)->recover();

	}

	public function get_where($id,$name){
			echo "<hr>---".$name."------".$id."----<hr>";
			$user=$this->model('User');
			var_dump($user->where("id",'>',$id)->orWhere('name',$name)->get());

	}
	public function get_orwhere($id){
			echo "hello";
			$user=$this->model('User');
			$user->setTable('users');
			var_dump($user->where("user_type","user")
						->where("password",'ahuhsujd')
							->orWhere("id",">",$id)
							->orWhere('name','=','Nigar')
							->get()
            );


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
			$user->setTable('nese');
            $this->enc->createToken('sjsj');

//            print_r('<pre>');
//            print_r($user->rawQuery("SELECT `id` FROM `nese` WHERE `id` = :name"));
//            print_r($user->where('id', $org)->get('id, ad, soy'));
//            print_r('</pre>');

            $this->valid->validation_rules(array(
                'first' => 'required|min_len,2',
                'name'  => 'required|min_len,3|max_len,6'
            ));

            $validated_data = $this->valid->run($_POST);

            if($validated_data === false) {
                $ne = $this->valid->get_readable_errors(true);
                $this->View('home', ['name1'=>$user->username, 'error'=>$ne]);
            } else {
                print_r($validated_data); // validation successful

//                $this->enc->settingParams('blaaa','wsshh',256);
//                $hashed = $this->enc->encrypt();

//                $user->create([
//                    'ad'=>$_POST['first'],
//                    'soy'=>$_POST['name'],
//                    //nezere alaq uni password-du ona gore ishleyek.
//                    'uni'=> $hashed
//
//                ]);
            }


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

	public function patch_test(){
        echo "It works (patch)";

    }

	public function options_test(){
		echo "It works (options)";
	}

	public function post_file()
	{
		$config['input_name']='file_name';
		$config['submit_name']='submit';
		$config['upload_path']= 'uploads/';
		$config['max_size'] = '100';
		$config['allowed_types'] = 'jpeg|jpg|png|gif';

    $result=$this->loader()
                 ->library("Upload",$config)
                 ->file_upload();

		return $this->View('upload', ['file'=>$result]);

	}

}
