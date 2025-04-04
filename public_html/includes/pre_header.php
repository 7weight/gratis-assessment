<?php
	// Fixes "Warning: Cannot modify header information - headers already sent by"
	ob_start();


	// TIMEZONE
	date_default_timezone_set('America/New_York');

	// ALL FILES AND REFERENCES ARE TO THE ROOT
	set_include_path($_SERVER['DOCUMENT_ROOT']);

	// CONNECTIONS
	include_once 'db_conn.php';


	// ----- START ERROR SECTION -----
	// Detect environment
	$isLocal = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

	/*if ($isLocal) {
	    $error_log_path = "/Users/grant/Sites/national50.net/public_html/logs/error_log";
	    // this is so I can change the bkgd color to know when i'm looking at local
	    $server_location = "local_dev";
	} else {
	    $error_log_path = "/home/irqimmtn/n50.7weight.com/logs/error_log";
	    // this is so I can change the bkgd color to know when i'm looking at local
	    $server_location = '';
	}*/


	$server_name = $_SERVER['SERVER_NAME'];

	if ($server_name == 'localhost' || $server_name == '7mbp-411.local:5757' || $server_name == 'national50.dev' || $isLocal) {
	    $error_log_path = "/Users/grant/Sites/national50.net/public_html/logs/error_log";

	} elseif ($server_name == 'n50.7weight.com') {
	    // TESTING server configuration
	    $error_log_path = "/home/irqimmtn/n50.7weight.com/logs/error_log";

	} elseif ($server_name == 'scores.national50.net') {
	    // Live server configuration
        $error_log_path = "/home/kkiilzek/scores.national50.net/logs/error_log";

	} else {
	    die('Unknown environment');
	}


	// Custom error handler function
	function myErrorHandler($errno, $errstr, $errfile, $errline) {
	    global $error_log_path;
	    $errorMsg = "\n[" . date("Y-m-d H:i:s") . "] Error: $errno - $errstr in $errfile on line $errline\n";
	    error_log($errorMsg, 3, $error_log_path);
	}

	// Custom exception handler function
	function myExceptionHandler($exception) {
	    global $error_log_path;
	    $errorMsg = "[" . date("Y-m-d H:i:s") . "] Exception: " . $exception->getMessage() . 
	    " in " . $exception->getFile() . " on line " . $exception->getLine() .
	    "\nStack trace:\n" . $exception->getTraceAsString() . "\n";
	    error_log($errorMsg, 3, $error_log_path);
	}

	// Setting the custom error and exception handlers
	set_error_handler('myErrorHandler');
	set_exception_handler('myExceptionHandler');

	// Enable error reporting
	error_reporting(E_ALL);
	ini_set('log_errors', 'On');
	ini_set('error_log', $error_log_path);

	// Test error to check if logging is working
	// trigger_error("This is a test error!", E_USER_NOTICE);

	// Configure session cookie parameters if a session is not already active
	if (session_status() == PHP_SESSION_NONE) {
	    $session_lifetime = 3600 * 24 * 30; // 30 days
	    $secure = isset($_SERVER['HTTPS']); // Only send the cookie over HTTPS if using HTTPS
	    $httponly = true; // Prevent JavaScript access to session cookie
	    $samesite = 'Lax'; // Adjust as needed for your use case

	    // Apply different methods to set session cookie parameters based on PHP version
	    if (PHP_VERSION_ID < 70300) {
	        session_set_cookie_params($session_lifetime, '/; samesite=' . $samesite, $_SERVER['HTTP_HOST'], $secure, $httponly);
	    } else {
	        session_set_cookie_params([
	            'lifetime' => $session_lifetime,
	            'path' => '/',
	            'domain' => $_SERVER['HTTP_HOST'],
	            'secure' => $secure,
	            'httponly' => $httponly,
	            'samesite' => $samesite
	        ]);
	    }

	    // Start the session
	    session_start();
	}


	// ----- END ERROR SECTION -----






	// Include functions
	include_once 'functions.php';

	

?>
