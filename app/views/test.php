<?php

// // Dosya ve yeni boyut
// $dosya = 'uploads/mypic.jpg';
// // $filename='dont.jpg';
// // // İçerik türü
// // // header('Content-type: image/jpeg');
// //
// // // Yeni resmin boyutları
// list($gen, $yük) = getimagesize($dosya);
// //
// $oran = $gen/$yük;
// // $yenigen = $gen * $oran;
// $yenigen =600;
// $yeniyük = ($yük /$gen) * $yenigen;
// //
// // // Resimleri yükleyelim
// $kaynak = imagecreatefromjpeg($dosya);
// $hedef = imagecreatetruecolor($yenigen, $yeniyük);
// //
// // // Resmi örnekleyelim
// imagecopyresampled($hedef, $kaynak, 0, 0, 0, 0, $yenigen, $yeniyük, $gen, $yük);
// //
// // // Resmi çıktılayalım
// imagejpeg($hedef,$dosya,80);
//
// ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    print_r($test);
    var_dump($test);
     ?>
    <h1>This is test view</h1>
   <!-- <img src="../>" alt=""> -->
  </body>
</html>
