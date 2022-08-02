<?php
	session_start();
	setcookie('keep_id', $sessions_cookies_id,  7);
	session_destroy();
	header('location: index.php');
?>