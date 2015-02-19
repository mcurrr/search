<?php
require 'core.inc.php';
require 'connect.inc.php';

if(!loggedin()) {

	if (isset($_POST['nik']) && isset($_POST['password']) && isset($_POST['password_again'])) {
		if (!empty($_POST['nik']) && !empty($_POST['password']) && !empty($_POST['password_again'])) {
			$nik = mysqli_real_escape_string($link, $_POST['nik']);
			$pass = sha1(mysqli_real_escape_string($link, $_POST['password']));
			$pass_2 = sha1(mysqli_real_escape_string($link, $_POST['password_again']));
			$email = mysqli_real_escape_string($link, $_POST['email']);
			if ($pass != $pass_2) {
				echo "Passwords do not match.";
			}
			else {
				$query = "SELECT `id`, `password` FROM `users` WHERE `nik` = '".$nik."'";
				if ($result = mysqli_query($link, $query)) {
					$count = mysqli_num_rows($result);
					if ($count == 0) {
						$query = "INSERT INTO `users` (`nik`,`password`) VALUES ('".$nik."','".$pass."')";
						if ($result = mysqli_query($link, $query)) {
							if(!empty($email)) {
								$query = "UPDATE `users` SET `email`='".$email."'";
								if ($result = mysqli_query($link, $query)) {
									//send email

									mysqli_free_result($result);
								}
								else {
									echo "Error: ".mysqli_error($link);
								}
							}
							$query = "SELECT `id` FROM `users` WHERE `nik`='".$nik."'";
							if ($result = mysqli_query($link, $query)) {
								$arr = mysqli_fetch_assoc($result);
								$id = $arr['id'];
								$_SESSION['id'] = $id;
								// mysqli_free_result($result);
								header('Location: search.php');
							}
							else {
								echo "Error: ".mysqli_error($link);
							}
						}
						else {
							echo "Error: ".mysqli_error($link);
						}
					}
					else {
						$arr = mysqli_fetch_assoc($result);
						$pass_base = $arr['password'];
						if($pass == $pass_base) {
								$id = $arr['id'];
								$_SESSION['id'] = $id;
								header('Location: search.php');
						}
						else {
							echo 'Nik is already taken by someone';
						}
					}
				}
				else {
					echo "Error: ".mysqli_error($link);
				}
			}
		}
		else {
			echo 'Please fill required fields.';
		}
	}
}
else {
	echo 'You\'re already registered. Please log in';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>registration</title>
</head>
<body>
	
<h3>Registration</h3><br>
<form action="registr.php" method="POST">
	Nik: <br> <input type="text" name="nik" autocomplete="off" value="" required id="nik"> <label for="nik"></label><br>
	Password: <br> <input type="password" name="password" required><br>
	Password again: <br> <input type="password" name="password_again" required><br>
	Email: <br> <input type="email" name="email" autocomplete="off" value=""><br><br>
	<input type="submit" value="Register">
	<input type="reset" value="Reset">
</form>
<br>
<a href="loginForm.inc.php">Log in</a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
<script src="main.js"></script>
</body>
</html>