<?php
/**
 * Created by PhpStorm.
 * User: gunel
 * Date: 13-Mar-17
 * Time: 10:31 AM
 */

class Encryption{


//Key
//An encryption key is a piece of information that controls the cryptographic process and permits a plain-text string to be encrypted,
// and afterwards - decrypted. It is the secret “ingredient” in the whole process that allows you to be the only one who is able to decrypt
// data that you’ve decided to hide from the eyes of the public. After one key is used to encrypt data, that same key provides the only means
// to decrypt it, so not only must you chose one carefully, but you must not lose it or you will also lose access to the data.


//Salt
//Cryptographic salt data is basically a bit of data which makes it more difficult to crack the data. If you are using salt, then it is
//impossible to exploit your password. Salt is a string which is hashed with password so that dictionary attacks would not work.


    public $key;

    private function setKey($key){

        $this->key = md5($key);
        return $this->key;
    }

    public function encryptData($string, $key){

        $key = $this->setKey($key);
        $str = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB)));
        return $str;
    }

    public function decryptData($string){

        $string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, base64_decode($string), MCRYPT_MODE_ECB));
        return $string;
    }




}