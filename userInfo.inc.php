<?php
require 'connect.inc.php';


$query = "SELECT `id` FROM `characters` WHERE `founded` = '1' AND `by whom` = '".getuserfield('nik')."'";
if ($result = mysqli_query($link, $query)) {
	$personal = mysqli_num_rows($result);
}
else {
	echo 'Error: '.mysqli_error($link);
}
?>

<br>
<h2>Personal statictic:</h2>
<p>You've discavered:
<?php
echo '<b>'.$personal.'</b><br>';
?>
</p>
