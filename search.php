<?php
require 'connect.inc.php';
require 'core.inc.php';

if (!loggedin()) {
	header('Location: loginForm.inc.php');
}
else {
	$logged = 'You\'re logged in, <b>'.getuserfield('nik').'</b><a href="logout.php">Log out</a>';
	$output = '';
	//search

	if(isset($_POST['search']) && !empty($_POST['search'])) {
		$search_q = $_POST['search'];
		$search_q = mysqli_real_escape_string($link, trim($search_q, " \t."));

		$query = "SELECT * FROM `characters` WHERE `name1` LIKE '$search_q'
										        OR `name2` LIKE '$search_q'
										        OR `name3` LIKE '$search_q'
										        OR `name4` LIKE '$search_q'
										        OR `name5` LIKE '$search_q'";
		if ($result = mysqli_query($link, $query)) {
			$count = mysqli_num_rows($result);
			if ($count == 0) {
				$output = "None.";
			}
			elseif ($count == 1) {
				$arr = mysqli_fetch_assoc($result);

				$id = $arr['id'];
				$name1 = $arr['name1'];
				$name2 = $arr['name2'];
				$name3 = $arr['name3'];
				$name4 = $arr['name4'];
				$name5 = $arr['name5'];
				$description = $arr['description'];
				$by = $arr['by whom'];
				$output = '<b>'.$name1.' '.$name2.' '.$name3.' '.$name4.' '.$name5.'</b>: \'<em>'.trim($description).' </em> \'';
				
				if(!$arr['founded']) {
					$query = "UPDATE `characters` SET `founded` = '1',`by whom` = '".getuserfield('nik')."' WHERE `id`=".$id."";
					if ($result = mysqli_query($link, $query)) {
						$query = "SELECT `count` FROM `users` WHERE `nik` = '".getuserfield('nik')."'";
						if ($result = mysqli_query($link, $query)) {
							$arr = mysqli_fetch_assoc($result);
							$count = $arr['count'];
							$count += 1;
							$query = "UPDATE `users` SET `count` = '".$count."' WHERE `nik` = '".getuserfield('nik')."'";
							if ($result = mysqli_query($link, $query)) {
								$output .= '<br><b><em>CONGRATULATION! &nbsp;</em> You have found it!</b>';
							}
							else {
								echo "Error1: ".mysqli_error($link);
							}
						}
						else {
							echo "Error2: ".mysqli_error($link);
						}
					}
					else {
						echo "Error3: ".mysqli_error($link);
					}
				}
				else {
					$output .= ' <u>Founded by</u> <b>'.strtoupper($by).' </b><br>';
				}
			}
			else {
				$output = "Several of those. You need to be more specific.";
			}
		}
		else {
			echo "Error4: ".mysqli_error($link);
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>search</title>
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<header>
		<?php echo $logged; ?>
	</header>
	<div id="general">
		<?php include 'commonInfo.inc.php'; ?>
	</div>
	<div id="personal">
		<?php include 'userInfo.inc.php'; ?>
	</div>
	<div id="pic">
		<p>Must know them all</p>
	</div>
	<div id="home">
		<a href="../index.php"><img src="img/home.png" height="100" width="100" alt="home"></a>
	</div>
	<div id="gaming">
		<form action="search.php" method="POST">
			<input type="search" name='search' placeholder='a FULL name...' pattern=".{3,}" required title="3 characters minimum" autocomplete="off"><label for=""></label>
			<input type="submit" value="GO!">
		</form>
	</div>
	<div id="founded">
		<h4>Similar founded:</h4>
		<p id="output">
		<?php echo ($output); ?>
	</p>
	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
<script src="js/main.js"></script>
</body>
</html>

