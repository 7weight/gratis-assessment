<?php

include_once 'db_conn.php';

// START SESSION IF NOT ALREADY STARTED
	if (session_status() === PHP_SESSION_NONE) {
	    session_start();
	}


	function isSessionStarted() {
	    if (php_sapi_name() !== 'cli') {
	        if (version_compare(phpversion(), '5.4.0', '>=')) {
	            // PHP 5.4.0 and later
	            return session_status() === PHP_SESSION_ACTIVE;
	        } else {
	            // PHP < 5.4.0
	            return session_id() !== '';
	        }
	    }
	    return false; // Assume false if running from CLI
	}




// RECORD THE URL THE USER IS TRYING TO ACCESS TO REDIRECT THEM AFTER LOGIN
	if (isset($_SERVER['REQUEST_URI']) && !str_contains($_SERVER['REQUEST_URI'], '/u_login.php')) {
	    // Only set the requested_url if it's not the login page
	    $_SESSION['requested_url'] = $_SERVER['REQUEST_URI'];
	}

// HANDLE ADMIN/RM ACCESS
	function check_access($required_group_id) {
	    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	        // Capture the current URL before redirecting to the login page
	        if (isset($_SERVER['REQUEST_URI']) && !str_contains($_SERVER['REQUEST_URI'], '/u_login.php')) {
	            $_SESSION['requested_url'] = $_SERVER['REQUEST_URI'];
	        }
	        header('Location: /u_login.php');
	        exit();
	    }

	    if ($_SESSION['usr_group'] != $required_group_id) {
	        header('Location: /err_unauthorized.php');
	        exit();
	    }
	}


// LOGIN
// LOGIN PROCESS AFTER FORM HAS BEEN SUBMITTED
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
	    $email = $_POST['username'];
	    $password = $_POST['password'];

	    // TRIM LEADING AND TRAILING SPACES
	    $email = trim($email);

	    // NORMALIZE EMAIL TO LOWERCASE
	    $email = strtolower($email);

	    // REMOVE EXTRA DOTS IN THE LOCAL PART OF THE EMAIL
	    $emailParts = explode('@', $email);
	    if (count($emailParts) === 2) { // ENSURE THE EMAIL IS PROPERLY FORMATTED
	    	$localPart = str_replace('.', '', $emailParts[0]);
	    	$email = $localPart . '@' . $emailParts[1];
	    }
	    // PREPARE THE SQL STATEMENT TO CHECK THE USERS TABLE
	    $sql = "SELECT id, email, fname, lname, usr_group, avatar, password FROM users WHERE email = ?";

	    // PREPARE THE SQL STATEMENT
	    if ($stmt = $conn->prepare($sql)) {
	        $stmt->bind_param("s", $email);

	        // EXECUTE THE STATEMENT
	        if ($stmt->execute()) {
	            $stmt->store_result();

	            // VERIFY IF THE USER EXISTS IN THE USERS TABLE
	            if ($stmt->num_rows == 1) {
	                $stmt->bind_result($id, $email, $fname, $lname, $usr_group, $avatar, $hashed_password);
	                $stmt->fetch();
	            } else {
					// CONVERT EMAIL TO LOWERCASE
					$email = strtolower($email);
	            }

	            // USE PASSWORD_VERIFY TO CHECK THE PASSWORD
	            if (isset($id) && password_verify($password, $hashed_password)) {
	                session_regenerate_id(true); // REGENERATE SESSION ID FOR SECURITY


	                // SET USER SESSION VARS
	                $_SESSION['usr_id'] = $id;
	                $_SESSION['username'] = $email;
	                $_SESSION['logged_in'] = true;
	                $_SESSION['email'] = $email;
	                $_SESSION['avatar'] = $avatar;
	                $_SESSION['name'] = formatUserName($fname, '', true, false) . " " . formatUserName('', $lname, false, true);
	                $_SESSION['usr_group'] = $usr_group;
	                
	                switch ($usr_group) {
	                    case '1':
	                        $_SESSION['usr_group_name'] = 'Administrator';
	                        break;
	                    case '50':
	                        $_SESSION['usr_group_name'] = 'Super Admin';
	                        break;
	                    default:
	                        break;
	                }

	                // LOGGING USER ACTIVITY FOR DEBUGGING
	                logMessage("usr_id: ". $_SESSION['usr_id'], 'login');
	                logMessage("name: ". $_SESSION['name'], 'login');
	                logMessage("email: ". $_SESSION['email'], 'login');
	                logMessage("avatar: ". $_SESSION['avatar'], 'login');
	                logMessage("usr_group: ". $_SESSION['usr_group'], 'login');
	                logMessage("logged_in: ". $_SESSION['logged_in'], 'login');
	                

	                // LOGGING USER ACTIVITY FOR DEBUGGING
					$info = getBrowserInfo();

					$usr_browser = $info['browser'];
					$usr_version = $info['version'];
					$usr_os = $info['os'];
					$usr_userAgent = $info['userAgent'];

					logMessage("Browser: $usr_browser", 'admin');
					logMessage("Version: $usr_version", 'admin');
					logMessage("Operating System: $usr_os", 'admin');
					logMessage("User Agent: $usr_userAgent", 'admin');

					// REDIRECT AFTER SUCCESSFUL LOGIN
	                header("Location: manage.php");
	                exit();

	            } else {
	                $error = 'Invalid password.';
	            }
	        } else {
	            $error = 'Oops! Something went wrong. Please try again later.';
	        }
	        $stmt->close();
	    } else {
	        $error = 'Database connection error.';
	    }
	}

	if (isset($error)) {
	    echo $error; // DISPLAY THE ERROR MESSAGE IF ANY
	}





// VALIDATE SESSION IP: STORE THE USER'S IP ADDRESS IN THE SESSION AND VALIDATE IT ON EACH REQUEST TO MITIGATE SESSION HIJACKING.
	if (!isset($_SESSION['ip_address'])) {
	    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
	}
	if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
	    // Possible session hijacking attempt
	    session_destroy();
	    header('Location: u_login.php');
	    exit();
	}


// HIDE CONTENT FROM NON-AUTH USERS
	function is_logged_in() {
		return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
	}

	function has_access($allowed_group_ids) {
		if (!is_logged_in()) {
			return false;
		}
		return in_array($_SESSION['usr_group'], $allowed_group_ids);
	}




// BROWSER INFORMATION
	function getBrowserInfo() {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$browser = "Unknown Browser";
		$os = "Unknown OS";

   		// Get the Operating System
		if (preg_match('/linux/i', $userAgent)) {
			$os = 'Linux';
		} elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
			$os = 'Mac';
		} elseif (preg_match('/windows|win32/i', $userAgent)) {
			$os = 'Windows';
		} elseif (preg_match('/android/i', $userAgent)) {
			$os = 'Android';
		} elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
			$os = 'iOS';
		}

    	// Get the Browser
		if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
			$browser = 'Internet Explorer';
		} elseif (preg_match('/Firefox/i', $userAgent)) {
			$browser = 'Firefox';
		} elseif (preg_match('/Chrome/i', $userAgent)) {
			$browser = 'Chrome';
		} elseif (preg_match('/Safari/i', $userAgent)) {
			$browser = 'Safari';
		} elseif (preg_match('/Opera/i', $userAgent)) {
			$browser = 'Opera';
		} elseif (preg_match('/Netscape/i', $userAgent)) {
			$browser = 'Netscape';
		}

    	// Get the version
		$known = array('Version', $browser, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $userAgent, $matches)) {
        // We have no matching number, just continue
		}

    	// See how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
        // We will have two since we are not using 'other' argument yet
        // see if version is before or after the name
			if (strripos($userAgent, "Version") < strripos($userAgent, $browser)) {
				$version = $matches['version'][0];
			} else {
				$version = $matches['version'][1];
			}
		} else {
			$version = $matches['version'][0];
		}

    	// Check if we have a version number
		if ($version == null || $version == "") {
			$version = "?";
		}

		return array(
			'userAgent' => $userAgent,
			'browser' => $browser,
			'version' => $version,
			'os' => $os
		);
	}

	


// WRITES TO A LOG FILE
	function logMessage($message, $log_name) {
		// error_log("Reached logMessage function with log_name: $log_name and message: $message");
	    switch ($log_name) {
	        case 'users':
	            $logFile = 'log_users.txt';
	            break;
	        case 'members':
	            $logFile = 'log_users.txt';
	            break;
	        case 'upload':
	            $logFile = 'log_upload.txt';
	            break;
	        case 'clubs':
	            $logFile = 'log_clubs.txt';
	            break;
	        case 'matches':
	            $logFile = 'log_matches.txt';
	            break;
	        case 'agg':
	            $logFile = 'log_agg.txt';
	            break;
	        case 'leaders':
	            $logFile = 'log_leaders.txt';
	            break;
	        case 'club_champ':
	        	$logFile = 'log_club_champs.txt';
	        	break;
	        case 'admin':
	        	$logFile = 'log_admin.txt';
	        	break;
	        case 'admin_score':
	        	$logFile = 'log_admin_score.txt';
	        	break;
	        case 'misc':
	        	$logFile = 'log_catchall.txt';
	        	break;
	        case 'log_password':
	        	$logFile = 'log_password.txt';
	        	break;
	        case 'login':
	        	$logFile = 'log_login.txt';
	        	break;
	        case 'raton':
	        	$logFile = 'log_raton.txt';
	        	break;
	        default:
	            $logFile = 'log_catchall.txt';
	            break;
	    }
	    $logFile_general = 'log_general.txt';

		$path = $_SERVER['DOCUMENT_ROOT'] . '/logs/';

		if (!file_exists($path)) {
		    mkdir($path, 0777, true); // CREATE THE DIRECTORY WITH PERMISSIONS
		}	
		$logFile = $path . $logFile;
		$logFile_general = $path . $logFile_general;


	    // SET THE TIME ZONE TO EASTERN TIME
	    $timezone = new DateTimeZone('America/New_York');
	    $dateTime = new DateTime('now', $timezone);
	    $currentTime = $dateTime->format('Y-m-d H:i:s');
	    // $currentTime = $dateTime->format('l jS \of F Y h:i:s A');

	    $temp_usr_id = $_SESSION['usr_id'] ?? '0';
	    $temp_name = $_SESSION['name'] ?? 'Non-Auth User';

		// error_log("temp_usr_id: " . $temp_usr_id);
		// error_log("temp_name: " . $temp_name);

		$logMessage = '';
		$logMessage_general = '';

		if (str_starts_with($message, '[')) {
			$logMessage .= "\n\n";
			$logMessage_general .= "\n\n";
		}

	    $logMessage .= $currentTime . " - user.id: " . $temp_usr_id . " - " . $temp_name . " -::- " . $message . PHP_EOL;
	    $logMessage_general .= $currentTime . " - user.id: " . $temp_usr_id . " - " . $temp_name . " -::- " . strtoupper($log_name) . " -::- " . $message . PHP_EOL;

	    // WRITE TO SPECIFIC LOG FILE
			$file = fopen($logFile, 'a');
			if (!$file) {
				error_log("Could not open log file: $logFile - Check permissions or path");
			    return; // HANDLE THE ERROR APPROPRIATELY
			}

		    if ($file) {
		        fwrite($file, $logMessage);
		        fflush($file);
		        fclose($file);
		    }

	    // WRITE TO GENERAL LOG FILE
			$file_general = fopen($logFile_general, 'a');
			if (!$file_general) {
				error_log("Could not open general log file: $logFile_general - Check permissions or path");
			    return; // HANDLE THE ERROR APPROPRIATELY
			}

		    if ($file_general) {
		        fwrite($file_general, $logMessage_general);
		        fflush($file_general);
		        fclose($file_general);
		    }
		}


// ************************************
// NAMES
// ************************************


	function formatUserName($fname = '', $lname = '', $includePrefix = true, $includeSuffix = true, $omitSpecificSuffixes = false) {
	    // List of common prefixes
	    $prefixes = ['Dr', 'Mr', 'Mrs', 'Ms', 'Miss', 'Mx', 'Prof', 'Rev', 'Sir', 'Dame', 'Lord', 'Lady'];

	    // List of common suffixes
	    $suffixes = ['Jr', 'Sr', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'MD', 'DDS', 'PhD', 'JD', 'Esq', 'CPA', 'RN', 'DO', 'DVM', 'Fr', 'Rev'];

	    // List of suffixes to omit if the argument is true
	    $suffixesToOmit = ['MD', 'DDS', 'PhD', 'JD', 'Esq', 'CPA', 'RN', 'DO', 'DVM', 'Fr', 'Rev'];

	    // List of suffixes that should always be uppercase
	    $suffixesToUppercase = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'MD', 'DDS', 'PhD', 'JD', 'CPA', 'RN', 'DO', 'DVM'];

	    // Initialize prefix and suffix variables
	    $prefix = '';
	    $suffix = '';

	    // If only the last name is provided
	    if (empty($fname) && !empty($lname)) {
	        // Split the last name into parts to check for suffixes
	        $lastNameParts = explode(' ', trim($lname));

	        // Detect if the last part of the last name is a suffix
	        if (!empty($lastNameParts) && in_array(strtoupper(trim(end($lastNameParts), '.')), array_map('strtoupper', $suffixes))) {
	            $potentialSuffix = trim(array_pop($lastNameParts), '.');
	            if ($includeSuffix && (!$omitSpecificSuffixes || !in_array(strtoupper($potentialSuffix), array_map('strtoupper', $suffixesToOmit)))) {
	                // Ensure the suffix is properly formatted
	                if (in_array(strtoupper($potentialSuffix), $suffixesToUppercase)) {
	                    // $suffix = ', ' . strtoupper(htmlspecialchars($potentialSuffix));
	                    $suffix = ' ' . strtoupper(htmlspecialchars($potentialSuffix));
	                } else {
	                    // $suffix = ', ' . ucfirst(htmlspecialchars($potentialSuffix));
	                    $suffix = ' ' . ucfirst(htmlspecialchars($potentialSuffix));
	                }
	            }
	        }

	        // Format the last name (capitalize each part including hyphenated names)
	        $formattedLastName = implode(' ', array_map(function($part) {
	            return implode('-', array_map('ucfirst', explode('-', $part)));
	        }, $lastNameParts));

	        // Construct the formatted last name with suffix if needed
	        return trim($formattedLastName . ($suffix ? $suffix : ''));
	    }

	    // If both first name and last name are provided, proceed as usual

	    // Detect if the first part of the first name is a prefix
	    $nameParts = explode(' ', trim($fname));
	    if (in_array(strtolower(trim($nameParts[0], '.')), array_map('strtolower', $prefixes))) {
	        $prefix = ucfirst(trim(array_shift($nameParts), '.')) . '.';
	    }

	    // Remaining part of the first name
	    $firstName = implode(' ', array_map('ucfirst', $nameParts));

	    // If no last name is provided, return the formatted first name and prefix if included
	    if (empty($lname)) {
	        return trim(($includePrefix && $prefix ? $prefix . ' ' : '') . $firstName);
	    }

	    // Split the last name into parts
	    $lastNameParts = explode(' ', trim($lname));

	    // Detect if the last part of the last name is a suffix
	    if (!empty($lastNameParts) && in_array(strtoupper(trim(end($lastNameParts), '.')), array_map('strtoupper', $suffixes))) {
	        $potentialSuffix = trim(array_pop($lastNameParts), '.');
	        if ($includeSuffix && (!$omitSpecificSuffixes || !in_array(strtoupper($potentialSuffix), array_map('strtoupper', $suffixesToOmit)))) {
	            // Ensure the suffix is properly formatted
	            if (in_array(strtoupper($potentialSuffix), $suffixesToUppercase)) {
	                // $suffix = ', ' . strtoupper(htmlspecialchars($potentialSuffix));
	                $suffix = ' ' . strtoupper(htmlspecialchars($potentialSuffix));
	            } else {
	                // $suffix = ', ' . ucfirst(htmlspecialchars($potentialSuffix));
	                $suffix = ' ' . ucfirst(htmlspecialchars($potentialSuffix));
	            }
	        }
	    }

	    // Format the last name (capitalize each part including hyphenated names)
	    $formattedLastName = implode(' ', array_map(function($part) {
	        return implode('-', array_map('ucfirst', explode('-', $part)));
	    }, $lastNameParts));

	    // Construct the formatted full name
	    $formattedName = trim(
	        ($includePrefix && $prefix ? $prefix . ' ' : '') .
	        ($firstName ? $firstName . ' ' : '') .
	        $formattedLastName .
	        ($suffix ? $suffix : '')
	    );

	    return $formattedName;
	}



	function formatName($name) {
	    // Convert to lowercase first
	    $name = strtolower(htmlspecialchars($name ?? ''));

	    // Split the name into parts to handle multi-part names
	    $nameParts = explode(' ', $name);

	    // Loop through each part and apply appropriate capitalization
	    $formattedParts = array_map(function ($part) {
	        // Handle specific cases for prefixes like "Mc", "Mac", "O'" etc.
	        if (preg_match('/^(mc|mac)([a-z]+)/', $part, $matches)) {
	            return ucfirst($matches[1]) . ucfirst($matches[2]);
	        }

	        // Capitalize the first letter of each part
	        return ucfirst($part);
	    }, $nameParts);

	    // Rejoin the parts
	    return implode(' ', $formattedParts);
	}

	// FULL NAME
	function formatFullName($fullName) {
	    // List of common suffixes
	    $suffixes = ['Jr', 'Sr', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'MD', 'DDS', 'PhD', 'JD', 'Esq', 'CPA', 'RN', 'DO', 'DVM', 'Sr', 'Fr', 'Rev'];
	    // List of common prefixes
	    $prefixes = ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr', 'Prof'];

	    // Split the full name into parts
	    $nameParts = explode(' ', $fullName);

	    // Initialize components
	    $prefix = '';
	    $firstName = '';
	    $lastNameParts = [];
	    $suffix = '';

	    // Detect prefix (first part, if it matches a known prefix)
	    if (in_array(strtolower($nameParts[0]), array_map('strtolower', $prefixes))) {
	        $prefix = array_shift($nameParts);
	    }

	    // The first name is usually the next part after the prefix (if present)
	    if (!empty($nameParts)) {
	        $firstName = ucfirst(strtolower(array_shift($nameParts)));
	    }

	    // Detect suffix (last part, if it matches a known suffix)
	    if (!empty($nameParts) && in_array(strtoupper(end($nameParts)), array_map('strtoupper', $suffixes))) {
	        $suffix = array_pop($nameParts);
	    }

	    // The remaining parts are the last name
	    $lastNameParts = $nameParts;

	    // Format the last name using formatName() function
	    $lastName = formatName(implode(' ', $lastNameParts));

	    // Construct the formatted full name
	    $formattedFullName = trim(
	        ($prefix ? $prefix . ' ' : '') .
	        ($firstName ? $firstName . ' ' : '') .
	        $lastName .
	        ($suffix ? ' ' . htmlspecialchars($suffix) : '')
	    );

	    return $formattedFullName;
	}




	function fname_prefix($inny){
		// List of common prefixes
		$prefixes = ['Dr', 'Mr', 'Mrs', 'Ms', 'Miss', 'Mx', 'Prof', 'Rev', 'Sir', 'Dame', 'Lord', 'Lady'];

		// Split the first name by space to detect a possible prefix
		$firstNameParts = explode(' ', $inny);
		$prefix = '';
		$firstName = ucfirst(strtolower(htmlspecialchars($firstNameParts[0] ?? '')));

		// Check if the first part is a recognized prefix
		if (in_array(ucfirst(strtolower($firstNameParts[0])), $prefixes)) {
		    $prefix = ucfirst(strtolower(htmlspecialchars($firstNameParts[0]))) . ' ';
		    $firstName = ucfirst(strtolower(htmlspecialchars($firstNameParts[1] ?? '')));
		}

		// Display the full name with prefix (if present)
		$new_fname = $prefix . ' ' . $firstName;
		return $new_fname;
	}

	function formatLastNameWithSuffix($lastName) {
	    // List of common suffixes
	    $suffixes = ['Jr', 'Sr', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'MD', 'DDS', 'PhD', 'JD', 'Esq', 'CPA', 'RN', 'DO', 'DVM', 'Sr', 'Fr', 'Rev'];

	    // Split the last name into parts to detect a possible suffix
	    $lastNameParts = explode(' ', $lastName);
	    $suffix = '';

	    // Check if the last part is a recognized suffix
	    if (!empty($lastNameParts) && in_array(strtoupper(end($lastNameParts)), array_map('strtoupper', $suffixes))) {
	        // Pop the suffix off the last name parts array
	        $suffix = array_pop($lastNameParts);
	    }

	    // Join remaining parts as the core last name
	    $coreLastName = implode(' ', $lastNameParts);

	    // Use the formatName() function to format the core last name
	    $formattedLastName = formatName($coreLastName);

	    // Append the suffix if it exists
	    if ($suffix !== '') {
	        $formattedLastName .= ' ' . htmlspecialchars($suffix);
	    }

	    return $formattedLastName;
	}


	function lname_suffix($inny) {
		// List of common suffixes
		$suffixes = ['Jr', 'Sr', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'MD', 'DDS', 'PhD', 'JD', 'Esq', 'CPA', 'RN', 'DO', 'DVM', 'Sr', 'Fr', 'Rev'];

		// Split the last name by space to detect a possible suffix
		$lastNameParts = explode(' ', $inny);
		$lastName = ucfirst(strtolower(htmlspecialchars($lastNameParts[0] ?? '')));
		$suffix = '';

		// Check if the last part is a recognized suffix
		if (count($lastNameParts) > 1) {
		    $potentialSuffix = strtoupper(end($lastNameParts));
		    if (in_array($potentialSuffix, $suffixes)) {
		        $suffix = ' ' . htmlspecialchars($potentialSuffix);
		        $lastName = ucfirst(strtolower(htmlspecialchars($lastNameParts[0])));
		    }
		}

		// Display the full name with suffix (if present)
		$new_lname = $lastName . ' ' . $suffix;
		return $new_lname;

	}



// RETURN ALL VARIABLES
	function getall_vars($inny, $name) {
		$tmp = '<h5>$' . $name . '</h5>';

		foreach($inny as $name=>$value) {
			// gets next array inside the array
			if(is_array($value)) {
				$tmp .= '[START '. $name . ' array - rgs] <br />';
				foreach($value as $name=>$value) {
					// echo '--- ' . $name."  =>  ";
					// echo $value."<br />";
					$tmp_value = ($value=='') ? 'no value [rgs]' : $value;
					$tmp .= '--- ' . $name . ' => ' . $tmp_value . '<br />';
					$tmp_value = '';
				}
				$tmp .= '[END '. $name . ' array - rgs] <br />';
			}else{
				// echo $name."  =>  ";
				// echo $value."<br />";
				$tmp_value = ($value=='') ? 'no value [rgs]' : $value;
				$tmp .= '<strong>' .$name . ' </strong> => ' . $tmp_value . '<br />';
				$tmp_value = '';
			}
		}
		return $tmp;
	}

?>