<?php
/**
 *
 */
 function word_limiter($value,$count=NULL)
{
  if (trim($value)=='') {
    return $value;
  }
  return  substr(trim(($value)),0,(int)$count);
}

function strmb($str='')
{

 mb_strlen($str); // 8
 mb_strlen($str,'UTF-8'); //6
return $str; // 8
}


 ?>
