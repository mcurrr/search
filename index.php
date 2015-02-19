<?php
require 'connect.inc.php';
require 'core.inc.php';

if (loggedin()) {
	header('Location: search.php');
}
else {
	header('Location: loginForm.inc.php');
}

?>