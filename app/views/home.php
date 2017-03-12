

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h3>
    <?php
//     echo $this->session->get_flashdata('danger') . '<br>';
// //    var_dump($this->session->hasSession('danger'));
//     if (isset($_POST['submit'])){
//         echo $_POST['first'];
//     }
    ?>
</h3>

	<h1>Hello, my name is <?php echo $data['name'] ?> </h1>
	<form method="POST" action="test" enctype="multipart/form-data">
		<input type="text" name="first">
		<input type="submit" name="submit">
		</form>

</body>
</html>
