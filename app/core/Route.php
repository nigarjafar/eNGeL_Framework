<?php


class Route{
	private static $routes=array();

	public static function  get($url, $method){
		$route["requestType"]="GET";
		$route["method"]=$method;
		$route["url"]= explode('/',$url);	
		array_push(self::$routes,$route);
		return null;
	}

	public static function  post($url, $method){
		$route["requestType"]="POST";
		$route["method"]=$method;
		$route["url"]= explode('/',$url);	
		array_push(self::$routes,$route);
		return null;
	}

	public static function  put($url, $method){
		$route["requestType"]="PUT";
		$route["method"]=$method;
		$route["url"]= explode('/',$url);	
		array_push(self::$routes,$route);
		return null;
	}

	public static function  patch($url, $method){
		$route["requestType"]="PATCH";
		$route["method"]=$method;
		$route["url"]= explode('/',$url);	
		array_push(self::$routes,$route);
		return null;
	}

	public static function  delete($url, $method){
		$route["requestType"]="DELETE";
		$route["method"]=$method;
		$route["url"]= explode('/',$url);	
		array_push(self::$routes,$route);
		return null;
	}
	public static function  options($url, $method){
		$route["requestType"]="OPTIONS";
		$route["method"]=$method;
		$route["url"]= explode('/',$url);	
		array_push(self::$routes,$route);
		return null;
	}

	public static function call($request_url,$request_type){

		//explode request_url to its components
		$request_url=explode('/', $request_url);

		//If there is / end of $url , omit it
		if(empty($request_url[count($request_url)-1]))
			array_pop($request_url);

		//check for each route in routes array
		foreach (self::$routes as $key => $route) {

			//Check for request type (Get, Post, Delete..)
			if( $request_type!=$route["requestType"] )
				continue;
			
			//If request type is true, check for components
			$url=$route["url"];

			//Check for length of $url and $request_url
			if(count($url)!=count($request_url))
				continue;

			$parameters=array();

			for ($i=0;	$i<count($request_url); $i++) {
				//Dynamic part
				//if $url contains component like <something>, the relevant data in $request_url is copied to parameters[something] 
				if($url[$i][0] == '<' && $url[$i][strlen($url[$i]) - 1] == '>') {
					$key=substr($url[$i],1,-1);
   					$parameters[$key]=$request_url[$i];
				}
				//Static part
				else if( $url[$i]==$request_url[$i]){
					$isEqual=1;
				}
				//If $url is not equal to $request_url , break for loop.
				else{
					$isEqual=0;
					break;
				}
			}

			echo $isEqual;
				//If isEqual is 1, it means route is found, so we combine $route["method"] and parameters[] in one array.
			if($isEqual){
				$function=explode('@',$route["method"]);
				array_push($function,$parameters);
				break;
			}
		}

		//If $url is not found we return null;
		if(!isset($function))
			$function=null;

		return $function;
	}
}

