<?php
/**
 * Created by PhpStorm.
 * User: gunel
 * Date: 29-Mar-17
 * Time: 11:18 AM
 */
//it gives out full output of the given page url

class Parser{

    //curl handler
    public $ch;

    function __construct()
    {
        $this->ch = curl_init();

        //for certification. This solved my problem and also sent email using localhost but I suggest
        // to NOT use it on live version live. On your live server the code should work without this code.
        // This code makes your server insecure.
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
    }

    function setOutPut($url){
        //sends request to url and gets the data[view]
        curl_setopt($this->ch, CURLOPT_URL, $url);

        //normalda gelen data goruntuye gelmek isteyir, ashagdaki funku yazmaqla
        //gelen datani yaddasha verir ve istifade olunmasini gozleyir. 1 ise true demekdi.
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

        //when you dont want header.
        curl_setopt($this->ch, CURLOPT_HEADER, 0);

        //executes the respond;
        $output = curl_exec($this->ch);

        if ($output === False){
            echo 'cURL error: '. curl_error($this->ch);
        }

        //closing initialized ch;
        curl_close($this->ch);

        return $output;
    }
}