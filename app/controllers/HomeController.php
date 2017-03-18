<?php

class HomeController extends Controller
{
	protected $value;
	public function index()
	{
		echo "Hello index home\n";
	}

	public function get_about()
	{
		$fileName = 'uploads/mypic.jpg';
		  $result=$this->loader()
							  	->library('Img_lib',$fileName);
									$result->resize(30,30,'exact');
									$result->saveImage('uploads/mypic-exact.jpg');


  // print_r($result);
		return self::View('test');
	}

}
