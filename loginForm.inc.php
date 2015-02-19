<?php
require 'connect.inc.php';
include 'core.inc.php';

if (isset($_POST['nik']) && isset($_POST['pass'])) {
	if (!empty($_POST['nik']) && !empty($_POST['pass'])) {
		$nik = mysqli_real_escape_string($link, $_POST['nik']);
		$pass = sha1(mysqli_real_escape_string($link, $_POST['pass']));

		$query = "SELECT * FROM `users` WHERE `nik` = '$nik' AND `password` = '$pass'";
		if ($result = mysqli_query($link, $query)) {
			$count = mysqli_num_rows($result);
			if ($count == 0) {
				echo 'Invalid nik/password combination.';
			}
			else {
				$arr = mysqli_fetch_assoc($result);
				$id = $arr['id'];
				$_SESSION['id'] = $id;
				header('Location: index.php');
			}
		}
		else {
			echo "Error: ".mysqli_error($link);
		}
	}
	else {
		echo 'You must supply a nik and password.';
	}
}

?>
<h3>Log in</h3><br>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
	Nik: <br><input type="text" name="nik" autocomplete="off"><br>
	Password: <br><input type="password" name="pass"><br><br>
	<input type="submit" value="Log in">
</form>
<br>
<a href="registr.php">Registration</a>

<?php
include 'commonInfo.inc.php';
?>