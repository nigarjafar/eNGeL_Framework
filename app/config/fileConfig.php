<?php

/**
 *
 */
class fileConfig
{
  private $results=[];
 private $input_name;
 private $value=[];

 public function __construct($value=[])
 {
   $this->value=$value;
 }

  public function file_upload()
    {

     if (isset($_POST[$this->value['submit_name']])) {


    $file=$_FILES[$this->value['input_name']]['tmp_name'];
   $fileName=$_FILES[$this->value['input_name']]['name'];
   $target_dir=$this->value['upload_path'];
   $target_file = $target_dir.basename($_FILES[$this->value['input_name']]["name"]);

    // call file_size method()
      $file_size=($this->file_size())/1024;

    // call file_type method ()
      $file_type=$this->file_type();


         $type=explode('|',$this->value['allowed_types']);

          if ($file_size <$this->value['max_size'] && in_array($file_type, $type)) {
             move_uploaded_file($file, $target_file);
            return $results=[$target_file,$file_size,$file_type];
          }
          else {
            return "error";
          }
        }
      }


    public function file_size()
    {
      return  $results=$fileSize=$_FILES[$this->value['input_name']]['size'];
    }

    public function file_type()
    {
      return $results = pathinfo($_FILES[$this->value['input_name']]['name'], PATHINFO_EXTENSION);
    }
}




 ?>
