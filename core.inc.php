<?php
ob_start();
session_start();

function loggedin() {
	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		return true;
	}
	else {
		return false;
	}
}

function getuserfield($field) {
	global $link;
	$query = "SELECT `$field` FROM `users` WHERE `id` = '".$_SESSION['id']."'";
	if ($result = mysqli_query($link, $query)) {
		$arr = mysqli_fetch_assoc($result);
		return $arr[$field];
	}
	else {
		echo "Error: ".mysqli_error($link);
	}
};

?>