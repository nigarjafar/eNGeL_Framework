<?php
/**
 * Created by PhpStorm.
 * User: gunel
 * Date: 13-Mar-17
 * Time: 10:31 AM
 */

class Encryption{


////////KEY
//An encryption key is a piece of information that controls the cryptographic process and permits a plain-text string to be encrypted,
// and afterwards - decrypted. It is the secret “ingredient” in the whole process that allows you to be the only one who is able to decrypt
// data that you’ve decided to hide from the eyes of the public. After one key is used to encrypt data, that same key provides the only means
// to decrypt it, so not only must you chose one carefully, but you must not lose it or you will also lose access to the data.

//////////SALT
//Cryptographic salt data is basically a bit of data which makes it more difficult to crack the data. If you are using salt, then it is
//impossible to exploit your password. Salt is a string which is hashed with password so that dictionary attacks would not work.

///////////CIPHER AND MODE
//Cipher is one of the MCRYPT_ciphername constants of the name of the algorithm as string
//Choosing the best encryption cipher and mode is beyond the scope of this answer, but the final choice affects the size of both the encryption key
//and initialisation vector; for this post we will be using AES-256-CBC which has a fixed block size of 16 bytes and a key size of either
//16, 24 or 32 bytes.
//A block cipher is a deterministic and computable function of kk-bit keys and nn-bit (plaintext) blocks to nn-bit (ciphertext) blocks.
//(More generally, the blocks don't have to be bit-sized, nn-character-blocks would fit here, too). This means, when you encrypt the same plaintext
//block with the same key, you'll get the same result. (We normally also want that the function is invertible, i.e. that given the key and the ciphertext
//block we can compute the plaintext.)
//
//To actually encrypt or decrypt a message (of any size), you don't use the block cipher directly, but put it into a mode of operation. The simplest
//such mode would be electronic code book mode (ECB), which simply cuts the message in blocks, applies the cipher to each block and outputs the resulting
//blocks. (This is generally not a secure mode, though.)

//MODE
//A mode of operation describes how to repeatedly apply a cipher's single-block operation to securely transform amounts
//of data larger than a block.


    const M_CBC = 'cbc';
    const M_CFB = 'cfb';
    const M_ECB = 'ecb';
    const M_NOFB = 'nofb';
    const M_OFB = 'ofb';
    const M_STREAM = 'stream';


    protected $key;
    protected $cipher;
    protected $data;
    protected $mode;
    protected $iv;


    public function settingParams($data=null, $key=null, $blocksize=null, $mode=null)
    {
//
        $this->setData($data);
        $this->setKey($key);
        $this->setBlocksize($blocksize);
        $this->setMode($mode);
        $this->setIv('');
    }


    public function setData($data){
        $this->data = $data;

    }


    private function setKey($key){
//$this->key = $key;
        $this->key = md5($key);
//        return $this->key;

    }


    public function setMode($mode){

        switch ($mode){
            case Encryption::M_CBC:
                $this->mode = MCRYPT_MODE_CBC;
                break;
            case Encryption::M_CFB:
                $this->mode = MCRYPT_MODE_CFB;
                break;
            case Encryption::M_ECB:
                $this->mode = MCRYPT_MODE_ECB;
                break;
            case Encryption::M_NOFB:
                $this->mode = MCRYPT_MODE_NOFB;
                break;
            case Encryption::M_OFB:
                $this->mode = MCRYPT_MODE_OFB;
                break;
            case Encryption::M_STREAM:
                $this->mode = MCRYPT_MODE_STREAM;
                break;
            default:
                $this->mode = MCRYPT_MODE_ECB;
                break;
        }

    }


    public function setBlocksize($blocksize){
        switch ($blocksize){
            case 128:
                $this->cipher = MCRYPT_RIJNDAEL_128;
                break;
            case 192:
                $this->cipher = MCRYPT_RIJNDAEL_192;
                break;
            case 256:
                $this->cipher = MCRYPT_RIJNDAEL_256;
                break;
        }
    }


    public function setIv($iv){
        $this->iv = $iv;
    }


    public function getIv(){
        if ($this->iv==""){
            $iv_size = mcrypt_get_iv_size($this->cipher, $this->mode);
            $this->iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        }

        return $this->iv;
    }


    public function validParams(){
        if ($this->data!=null && $this->cipher!=null && $this->key!=null){
            return TRUE;
        }else{
            return false;
        }
    }


    public function encrypt(){

        if ($this->validParams()){
            $str = rtrim(base64_encode(mcrypt_encrypt($this->cipher, $this->key, $this->data, $this->mode, $this->getIv())));
            $arrParams = [$str, $this->key, $this->cipher, $this->mode, $this->iv];
            $implodedParams = implode('//', $arrParams);

            return $implodedParams;
        }else{
            throw new Exception('invalid params');
        }
    }


//    decryption is not needed. ///////////////////////////////////

//    public function decrypt(){
//
//
//        $explodedParams = explode('//',$this->data);
//
//        $string = rtrim(mcrypt_decrypt($explodedParams[2], $explodedParams[1], base64_decode($explodedParams[0]), $explodedParams[3], $explodedParams[4]));
//
//        return $string;
//    }


}