<?php
require 'connect.inc.php';
$dinamic_search = '';

if(isset($_POST['searchVal']) && !empty($_POST['searchVal'])) {
	$search_q = $_POST['searchVal'];
	$search_q = mysqli_real_escape_string($link, trim($search_q, " \t."));
	$query = "SELECT * FROM `characters` WHERE (`name1` LIKE '$search_q%'
									        OR `name2` LIKE '$search_q%'
									        OR `name3` LIKE '$search_q%'
									        OR `name4` LIKE '$search_q%'
									        OR `name5` LIKE '$search_q%')
									        AND `founded` = '1'";
	$query_run = mysqli_query($link, $query) or die(mysqli_error());
	$count = mysqli_num_rows($query_run);
	if ($count == 0) {
		$dinamic_search = '';
	}
	else {
		for ($count; $count>0; $count--) {
			$output = '';
			while($row = mysqli_fetch_assoc($query_run)) {
				$name1 = $row['name1'];
				$name2 = $row['name2'];
				$name3 = $row['name3'];
				$name4 = $row['name4'];
				$name5 = $row['name5'];
				$description = $row['description'];
				$by = $row['by whom'];

				$output = '<b>'.$name1.' '.$name2.' '.$name3.' '.$name4.' '.$name5.'</b>: \'<em>'.trim($description).' </em> \'';
				$dinamic_search .= $output.' <u>Founded by</u> <b>'.strtoupper($by).' </b><br>';
			};
		};
	}
}
echo ($dinamic_search);
?>
