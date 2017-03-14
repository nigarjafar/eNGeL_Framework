<?php

class HomeController extends Controller{
	protected $value;
	public function index(){
		echo "Hello index home\n";
	}

	public function get_about()
	{
		$config['source_image'] = 'uploads/mypic.jpg';
		$config['width']         = "";
		$config['height']       = 50;
		  $result['test']=$this->loader()
							  	->library('Img_lib',$config)->resize();

  // print_r($result);
		return self::View('test',$result);
	}

}
