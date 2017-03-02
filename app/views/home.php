<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h3>
    <?php
            echo $this->session->getSession('danger') . '<br>';

    ?>
</h3>
	<h1>Hello, my name is <?php echo $data['name'] ?> </h1>
	<form method="PUT" action="test">
		<input type="text" name="name" value="PUT">
		<input type="submit">
	</form>
	
</body>
</html>