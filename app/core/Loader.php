<?php

/**
 *
 */
class loader
{

  public function library($library, $params = [])
  {
    if (Empty($library)) {
       return  "Library Not Found";
    }

    else if (file_exists('../app/library/'.$library.'.php')){
        require '../app/library/'. $library.'.php';

        return new $library($params);
      }
  }


  public function helper($helper)
  {
    if (file_exists('../app/helpers/'.$helper.'.php')) {
      require '../app/helpers/'. $helper.'.php';
    }
  }
}



 ?>
