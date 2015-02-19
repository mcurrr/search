<?php
require 'connect.inc.php';
$name_clone = 0;

if(isset($_POST['searchVal']) && !empty($_POST['searchVal'])) {
	$search_n = $_POST['searchVal'];
	$search_n = mysqli_real_escape_string($link, trim($search_n, " \t."));
	$query = "SELECT * FROM `users` WHERE `nik` = '$search_n'";
	if ($result = mysqli_query($link, $query)) {
		$name_clone = mysqli_num_rows($result);
	}
	else {
		echo "Error: ".mysqli_error($link);
	}
}
echo (!!$name_clone);
?>