
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<p>File uploaded</p>
  <img src="../<?=$data['file'][0]?>" width="100px">
  <p> File Path :  <?=   $data['file'][0] ?></p>
  <p> File Size :  <?=   $data['file'][1] ?></p>
  <p> File Type :  <?=   $data['file'][2] ?></p>



</body>
</html>
