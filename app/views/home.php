

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

	<h1>Hello, my name is <?php echo $data['name1'] ?> </h1>

	<form method="POST" action="test" enctype="multipart/form-data">
		<input type="text" name="first"><br>
        <?php if (isset($data['error']['first'])) echo $data['error']['first']?><br>
        <input type="text" name="name"><br>
        <?php if (isset($data['error']['name'])) echo $data['error']['name']?><br>

        <input type="submit" name="submit">
		</form>

</body>
</html>
