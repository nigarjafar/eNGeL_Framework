<?php

/**
 *
 */
class fileConfig
{

  public function file_upload($fileName='')
    {
    $file=$_FILES['file_name']['tmp_name'];
   $fileName=$_FILES['file_name']['name'];
   $target_dir="uploads/";
   $target_file = $target_dir.basename($_FILES["file_name"]["name"]);
    move_uploaded_file($file, $target_file);

    }
}




 ?>
