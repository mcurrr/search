<?php 
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
$mysql_db = 'wp';

$link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

if (mysqli_connect_errno()) {
	print_r("No connection1: ".mysqli_connect_error());
	die();
}

?>