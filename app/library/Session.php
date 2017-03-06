<?php
/**
 * Created by PhpStorm.
 * User: gunel
 * Date: 01-Mar-17
 * Time: 11:06 AM
 */

class Session{
    function __construct()
    {
        session_start();
    }

    public function setSession($name, $value){
        $_SESSION[$name] = $value;
    }
    public function getSession($name){
        if (isset($_SESSION[$name])){
            $message = $_SESSION[$name];
//            unset($_SESSION[$name]);
            return $message;
        }

    }

    public function get_flashdata($name){
        if (isset($_SESSION[$name])) {
            $temp = $_SESSION[$name];
            $this->deleteSession($name);
            return $temp;
        }
    }


//    useless function !!!!!!!!!!!!
    public function deleteSession($name){
        unset($_SESSION[$name]);
    }

    //to check if session is setted or not
    public function hasSession($name){
        if (isset($_SESSION[$name])){
//            echo $name .' session is setted';
            return true;
        }else{
            return false;
            echo $name .' session is not setted';
        }
    }


    public function sessionPath($path) {
        ini_set(session.save_path, $path);
        }
}