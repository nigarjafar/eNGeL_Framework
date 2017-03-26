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
									$result->resize(50,null,'maxwidth');

				//  $result->freecrop(900,500,400,100);
			  	$result->save('uploads/img3.jpg');
				echo "<pre>";
				print_r($result);
				echo "</pre>";

		  return $this->View('test');
	}

}
