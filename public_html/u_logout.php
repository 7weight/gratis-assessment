<?php

	session_start();
	// Clear session variables
	$_SESSION = array();
	// Destroy the session
	session_destroy();
	header('Location: index.php'); 
	exit();
    



?>