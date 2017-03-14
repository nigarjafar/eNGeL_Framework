<?php

/**
 *
 */
class Upload
{
  protected $results=[];
 protected $input_name;
 protected $value=[];

 public function __construct($value=[])
 {
   $this->value=$value;
 }

  public function file_upload()
  {

    if (isset($_FILES[$this->value['input_name']])) {


       //call file_name method
       $target_file=self::file_name();
      // call file_size method()
        $file_size=self::file_size();

      // call file_type method ()
        $file_type=self::file_type();


       $type=explode('|',$this->value['allowed_types']);
       $file=$_FILES[$this->value['input_name']]['tmp_name'];

        if ($file_size <$this->value['max_size'] && in_array($file_type, $type))
         {
           move_uploaded_file($file, $target_file);

          return $results=[
            $target_file,
            $file_size,
            $file_type
          ];

        }
        else
        {
          return "";
        }
    }
}


    public function file_size()
    {
      $fileSize=$_FILES[$this->value['input_name']]['size'];
      return  $results=round($fileSize/1024);
    }


    public function file_type()
    {

      return $results = pathinfo($_FILES[$this->value['input_name']]['name'], PATHINFO_EXTENSION);

    }


    public function file_name()
    {
       $file=$_FILES[$this->value['input_name']]['tmp_name'];
       $fileName=$_FILES[$this->value['input_name']]['name'];
       $target_dir=$this->value['upload_path'];
       $target_file = $target_dir.basename($_FILES[$this->value['input_name']]["name"]);

       return $target_file;
    }
}





 ?>
