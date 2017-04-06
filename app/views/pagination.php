
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../app/views/assets/css/style.css">
</head>
<body>

	<?php
	$i=1;
	foreach ($data['posts'] as $key => $post) {
	?>
	
	<h4><?=$post->title?></h1>
	<?php
	
	
	}

	 ?>

	<?php $data['posts']->fullLinks() ?>
	<?php $data['posts']->simpleLinks() ?>
	<?php $data['posts']->numberLinks() ?>
	

</body>
</html>
