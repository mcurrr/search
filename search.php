<?php
require 'connect.inc.php';
require 'core.inc.php';

if (!loggedin()) {
	header('Location: loginForm.inc.php');
}
else {
	echo 'You\'re logged in, <b>'.getuserfield('nik').'</b><br><a href="logout.php">Log out</a><br>';
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
		$query_run = mysqli_query($link, $query) or die(mysqli_error());
		$count = mysqli_num_rows($query_run);
		if ($count == 0) {
			$output = "Nothing like.";
		}
		elseif ($count == 1) {
			$row = mysqli_fetch_assoc($query_run);

			$id = $row['id'];
			$name1 = $row['name1'];
			$name2 = $row['name2'];
			$name3 = $row['name3'];
			$name4 = $row['name4'];
			$name5 = $row['name5'];
			$description = $row['description'];
			$by = $row['by whom'];
			$output = '<b>'.$name1.' '.$name2.' '.$name3.' '.$name4.' '.$name5.'</b>: \'<em>'.trim($description).' </em> \'';
			
			if(!$row['founded']) {
				$query = "UPDATE `characters` SET `founded` = '1',`by whom` = '".getuserfield('nik')."' WHERE `id`=".$id."";
				mysqli_query($link, $query);
				$output .= '<br><b><em>CONGRATULATION!</em> You have found it!</b>';
			}
			else {
				$output .= ' <u>Founded by</u> <b>'.strtoupper($by).' </b><br>';
			}
		}
		else {
			$output = "Several of those. You need to be more specific.";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>search</title>
</head>
<body>

<h2>Simpsons</h2>
	<form action="search.php" method="POST">
		<input type="text" name='search' placeholder='Put any FULL name...' pattern=".{3,}" required title="3 characters minimum" autocomplete="off"><label for=""></label>
		<input type="submit" value="GO!">
	</form>
<br><br><br><br><br>
<h4>Similar founded:</h4>
<p id="output">
<?php echo ($output); ?>
</p>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
<script src="main.js"></script>
</body>
</html>


<?php
include 'commonInfo.inc.php';
include 'userInfo.inc.php';
?>