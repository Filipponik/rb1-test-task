<?
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<?
	$clicks = R::getAll('SELECT * FROM `clicks`');
	// TODO: удалить
	echo '<pre>';
	var_dump($clicks);
	echo '</pre>';
	?>
</body>
</html>