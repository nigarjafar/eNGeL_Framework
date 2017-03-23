<?php

class UserController extends Controller{

 	private $session;
    private $valid;
    // function __construct()
    // {
    //    $this->session = $this->loadLib('Session');
    //    $this->valid = $this->loadLib('Validation');
    // }
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
//encryption part
//
//        $data = "hello little lorem ipsum bla bla blsdl";
//
//        $enc = $this->loadLib('Encryption');
//        $hashed = $enc->generateKey($data, 'first');
//        var_dump($hashed);
        return $this->View('home', ['name1'=>$user->username]);
	}

	public function get_profile(){
		$user=$this->model('User');
		$user->setTable('users');

		$user=$user->get();
		var_dump($user);

		//var_dump($user->where('name','Engel')->whereBetween('id',1,10)->get(['id','name']));
	}

	public function get_all(){
		$user=$this->model('User');
		$user->setTable('users');
		
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
		$user=$user->withTrash()->where("id",$id)->update([
			'name'=>'EngelFM',
			'user_type'=>'user',
		]);

		var_dump($user);

	}

	public function get_delete($id){
			$user=$this->model('User');
			$user->setTable('users');
			$user->where("id",$id)->where('name',"Nigar")->forceDelete();

	}

	public function get_recover($id){
			$user=$this->model('User');
			$user->setTable('users');
			$user->where("id",'>',0)->recover();

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
//                print_r($validated_data); // validation successful

                $enc = $this->loadLib('Encryption');
                $hashed = $enc->encryptData('passwoord', 17);

//                $user->create([
//                    'ad'=>$_POST['first'],
//                    'soy'=>$_POST['name'],
//                    //nezere alaq uni password-du ona gore ishleyek.
//                    'uni'=> $hashed
//
//                ]);
            }
//            $dat = $user->get('uni');
//            foreach ($dat as $key){
//                $aa = $key['uni'];
//                $dd = $enc->decryptData($aa, 17);
//                var_dump($dd);
//            }

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

    $result=$this->loader()
                 ->library("Upload",$config)
                 ->file_upload();

		return $this->View('upload', ['file'=>$result]);

	}

}
