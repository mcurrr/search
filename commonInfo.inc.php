<?php
require 'connect.inc.php';

$query = "SELECT `id` FROM `characters` WHERE `founded` = '1'";
if ($result = mysqli_query($link, $query)) {
	$current = mysqli_num_rows($result);
}
else {
	echo 'Error: '.mysqli_error($link);
}

$query = "SELECT `id` FROM `characters` WHERE `founded` = '0'";
if ($result = mysqli_query($link, $query)) {
	$left = mysqli_num_rows($result);
}
else {
	echo 'Error: '.mysqli_error($link);
}
$max = array();
$query = "SELECT `id`, `count` FROM `users` WHERE `count` != '0'";
if ($result = mysqli_query($link, $query)) {
	$rows = mysqli_num_rows($result);
		for ($i=0; $i<$rows; $i++) {
				$arr_results = mysqli_fetch_assoc($result);
				$assoc_results[$arr_results['id']] = $arr_results['count'];
		}
	$max_count = max($assoc_results);
	$id_max = array_search($max_count, $assoc_results);
	$query = "SELECT `nik` FROM `users` WHERE `id` = '".$id_max."'";
	if ($result = mysqli_query($link, $query)) {
		$row = mysqli_fetch_assoc($result);
		$best = $row['nik'];
	}
	else {
		echo 'Error: '.mysqli_error($link);
	}
}
else {
	echo 'Error: '.mysqli_error($link);
}

?>

<br>
<br>
<br>
<br>
<h2>General tatictic:</h2>
<p>Have been discovered:
<?php echo '<b>'.$current.'</b><br>'; ?>
</p>
<p>Left:
<?php echo '<b>'.$left.'</b><br>'; ?>
</p>
<p>The BEST player is:
<?php echo '<b>'.$best.'</b><br>'; ?>
</p>
