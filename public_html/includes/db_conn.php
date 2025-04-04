<?php

	// DB CREDENTIALS
	$db_host = 'localhost';
	$db_user = 'root';
	$db_password = 'root';
	$db_db = 'gratis';

	// SIMPLE CONNECTION
	$conn = @new mysqli(
		$db_host,
		$db_user,
		$db_password,
		$db_db
	);

?>