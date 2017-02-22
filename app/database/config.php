<?php

class DBConnection extends PDO{

	var $username;
	var $password;
    var $dns;
    
    public function __construct($file = '../app/db.ini'){

        $this->parse_ini($file);
        try{
            parent::__construct( $this->dns,
                    $this->username,
                    $this->password,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $e){
            die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
        }
        
        
    }

    private function parse_ini($file){
        if (!$settings = parse_ini_file($file, TRUE)) 
            throw new exception('Unable to open ' . $file . '.');
        
        $this->dns=$settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .';dbname=' . $settings['database']['schema'];

        $this->username=$settings['database']['username'];
        $this->password= $settings['database']['password'];
    }


}




?>