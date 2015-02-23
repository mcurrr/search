<?php

require 'connect.inc.php';
include 'core.inc.php';

$warning = '';

if (isset($_POST['nik']) && isset($_POST['pass'])) {
	if (!empty($_POST['nik']) && !empty($_POST['pass'])) {
		$nik = mysqli_real_escape_string($link, $_POST['nik']);
		$pass = sha1(mysqli_real_escape_string($link, $_POST['pass']));

		$query = "SELECT * FROM `users` WHERE `nik` = '$nik' AND `password` = '$pass'";
		if ($result = mysqli_query($link, $query)) {
			$count = mysqli_num_rows($result);
			if ($count == 0) {
				$warning = 'Invalid nik/password combination.';
			}
			else {
				$arr = mysqli_fetch_assoc($result);
				$id = $arr['id'];
				$_SESSION['id'] = $id;
				header('Location: search.php');
			}
		}
		else {
			echo "Error: ".mysqli_error($link);
		}
	}
	else {
		$warning = 'You must supply a nik and password.';
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>log</title>
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div id="login">
		<h3>Log in</h3>
		<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
			<label for="nik">Nik: </label><br><input type="text" name="nik" autocomplete="off" class="logInput" required><br>
			<label for="pass">Password: </label><br><input type="password" name="pass" class="logInput" required><br><br>
			<input type="submit" value="Log in">
		</form>
		<br/>
		<a href="registr.php">Registration</a>
		<div id="warning">
			<?php echo $warning ?>
		</div>
	</div>

	<div id="general">
		<?php include 'commonInfo.inc.php'; ?>
	</div>
	<div id="pic">
		<p>Must know them all</p>
	</div>
	<div id="home">
		<a href="../index.php"><img src="img/home.png" height="100" width="100" alt="home"></a>
	</div>
</body>
</html>
