<?php
require 'connect.inc.php';


$query = "SELECT `count` FROM `users` WHERE `nik` = '".getuserfield('nik')."'";
if ($result = mysqli_query($link, $query)) {
	$arr = mysqli_fetch_assoc($result);
	$personal = $arr['count'];
}
else {
	echo 'Error: '.mysqli_error($link);
}
?>


<h2>Personal statictic:</h2>
<p><h4>You've discavered:</h4><br/>
<?php
echo '<b>'.$personal.'</b><br>';
?>
</p>
