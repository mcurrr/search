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
	if ($rows != 0) {
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
		$best = 'Nobody';
	}
}
else {
	echo 'Error: '.mysqli_error($link);
}

?>


<h2>General tatictic:</h2>
<p><h4>Have been discovered:</h4>
<?php echo '<b>'.$current.'</b><br>'; ?>
</p>
<p><h4>Left:</h4>
<?php echo '<b>'.$left.'</b><br>'; ?>
</p>
<p><h4>The BEST player is:</h4>
<?php echo '<b><em>'.$best.'</em></b><br>'; ?>
</p>
