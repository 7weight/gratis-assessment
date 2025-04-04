<?php
	// database connection
	$conn = new mysqli('localhost', 'root', 'root', 'gratis');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// Hash the password (use PASSWORD_DEFAULT or PASSWORD_BCRYPT)
	$plainPassword = 'gratis';
	$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

	// Update all users to use this hashed password
	$sql = "UPDATE users SET password = ? WHERE id = 3";
	$stmt = $conn->prepare($sql);

	if ($stmt) {
	    $stmt->bind_param("s", $hashedPassword);
	    if ($stmt->execute()) {
	        echo "Passwords updated for all users.";
	    } else {
	        echo "Execution failed: " . $stmt->error;
	    }
	    $stmt->close();
	} else {
	    echo "Preparation failed: " . $conn->error;
	}

	$conn->close();
?>
