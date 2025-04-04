<?php
	include_once 'functions.php';

	// FUNCTIONS - NEED TO MOVE THESE TO THE FUNCTIONS.PHP FILE
		function traverseArray($array, $name)
			{
				if($name == '') {
					$tmp = '';
				}else{
					$tmp = '<h2>$' . $name . '</h2>';
				}

			    // Loops through each element. If element again is array, function is recalled. If not, result is echoed.
			    foreach ($array as $key => $value)
			    {
			        if (is_array($value))
			        {
			            // Self::traverseArray($value); // Or
			            $tmp .= traverseArray_nextlevel($value,$key);
			        }
			        else
			        {
						$tmp_value = ($value == '') ? 'no value [rgs]' : $value;
						$tmp .= $key . ' => ' . $tmp_value . '<br />';
						$tmp_value = '';

			            // echo '--- ' . $key . " = " . $value . "<br />\n";
			        }
			    }
			    return $tmp;
			}	

			// if value in traverseArray is found to be an array, it's sent here for formatting
			function traverseArray_nextlevel($array,$name)
			{
				if(!isset($tmp_next)) {
					$tmp_next = '';
				}
				$tmp_next .= '[START '. $name . ' array - rgs] <br />';
			    // Loops through each element. If element again is array, function is recalled. If not, result is echoed.
			    foreach ($array as $key => $value)
			    {
			        if (is_array($value))
			        {
			            // Self::traverseArray($value); // Or
			            traverseArray_nextlevel($value, $key);
			        }
			        else
			        {
						$tmp_value = ($value == '') ? 'no value [rgs]' : $value;
						$tmp_next .= '--- ' . $key . ' => ' . $tmp_value . '<br />';
						$tmp_value = '';

			            // echo '--- ' . $key . " = " . $value . "<br />\n";
			        }
			    }
				$tmp_next .= '[END '. $name . ' array - rgs] <br />';
			    return $tmp_next;
			}	



		// ONLY RECORD SELECTED VARIABLES 
		function traverseArrayFiltered($array, $name)
		{
		    // Define the allowed keys
		    $allowed_keys = [
		        "ORIG_PATH_TRANSLATED", "ORIG_PATH_INFO", "SCRIPT_NAME", "REQUEST_URI", "QUERY_STRING",
		        "REQUEST_METHOD", "REDIRECT_URL", "SCRIPT_FILENAME", "SERVER_ADMIN", "DOCUMENT_ROOT",
		        "REMOTE_ADDR", "SERVER_PORT", "SERVER_ADDR", "SERVER_NAME", "HTTP_SEC_CH_UA",
		        "HTTP_ACCEPT_LANGUAGE", "HTTP_VIA", "HTTP_ORIGIN", "HTTP_PRAGMA", "HTTP_USER_AGENT",
		        "HTTP_SEC_CH_UA_PLATFORM", "HTTP_REFERER", "HTTP_HOST", "SSL_TLS_SNI", "HTTPS",
		        "REDIRECT_STATUS", "REDIRECT_SSL_SERVER_V_END", "REDIRECT_SSL_SERVER_V_START",
		        "PHP_SELF", "REQUEST_TIME_FLOAT", "REQUEST_TIME"
		    ];

		    $tmp = '<h2>$' . $name . '</h2>';

		    // Loop through only the allowed keys in the array
		    foreach ($allowed_keys as $key) {
		        if (isset($array[$key])) {
		            $value = $array[$key];
		            if (is_array($value)) {
		                $tmp .= traverseArray_nextlevel($value, $key);
		            } else {
		                $tmp_value = ($value == '') ? 'no value [rgs]' : htmlspecialchars($value);
		                $tmp .= $key . ' => ' . $tmp_value . '<br />';
		            }
		        }
		    }

		    return $tmp;
		}



	// --------------------------------------------
	// WRITTING TO LOG FILE FOR DEBUGGING
	if (
		isset($_POST['stock']) && isset($_POST['vin']) &&  isset($_POST['year']) && isset($_POST['mfg']) && isset($_POST['model']) &&
		isset($_POST['pkg']) && isset($_POST['cond']) &&
		isset($_POST['miles']) && isset($_POST['price']) && isset($_POST['sale_price'])
	) {

	$outtie = traverseArray($_POST, "_POST");
	logMessage("the post: " . $outtie, 'admin');
	logMessage("stock: " . $_POST['stock'], 'admin');
	logMessage("vin: " . $_POST['vin'], 'admin');
	logMessage("year: " . $_POST['year'], 'admin');
	logMessage("mfg: " . $_POST['mfg'], 'admin');
	logMessage("model: " . $_POST['model'], 'admin');
	logMessage("pkg: " . $_POST['pkg'], 'admin');
	logMessage("cond: " . $_POST['cond'], 'admin');
	logMessage("miles: " . $_POST['miles'], 'admin');
	logMessage("price: " . $_POST['price'], 'admin');
	logMessage("sale_price: " . $_POST['sale_price'], 'admin');
	}


	// --------------------------------------------
	// INSERT NEW RECORD

	if (
		isset($_POST['stock']) && isset($_POST['vin']) &&  isset($_POST['year']) && isset($_POST['mfg']) && isset($_POST['model']) &&
		isset($_POST['pkg']) && isset($_POST['cond']) &&
		isset($_POST['miles']) && isset($_POST['price']) && isset($_POST['sale_price'])
	) {
		$stock = $_POST['stock'];
		$vin = $_POST['vin'];
		$year = $_POST['year'];
		$mfg = $_POST['mfg'];
		$model = $_POST['model'];
		$pkg = $_POST['pkg'];
		$cond = $_POST['cond'];
		$miles = $_POST['miles'];
		$price = $_POST['price'];
		$sale_price = $_POST['sale_price'];

	  	
	  	$insert_sql = "
		INSERT INTO cars (stock, vin, year, model, pkg, cond, miles, price, sale_price, mfg)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		";

		$stmt = $conn->prepare($insert_sql);
		$stmt->bind_param("issssidddi", $stock, $vin, $year, $model, $pkg, $cond, $miles, $price, $sale_price, $mfg);


		if ($stmt->execute()) {
			echo "New car added successfully.";
		} else {
			echo "Error adding car: " . $stmt->error;
		}

		$stmt->close();
	}




	// --------------------------------------------
	// UPLOAD IMAGES, RENAME THEM - ONLY ALLOWING 3 IN THIS ASSESSMENT

	$upload_dir = __DIR__ . '/../images/inventory/';
	
	$stock = $_POST['stock'];

	for ($i = 1; $i <= 3; $i++) {
		$photoField = "photo{$i}";
		$primaryField = "primary{$i}";

		if (isset($_FILES[$photoField]) && $_FILES[$photoField]['error'] == 0) {
			$filename = basename($_FILES[$photoField]['name']);
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$new_filename = $stock . "-{$i}." . $ext;
			$target_path = $upload_dir . $new_filename;

			if (move_uploaded_file($_FILES[$photoField]['tmp_name'], $target_path)) {
				$is_primary = isset($_POST[$primaryField]) ? 1 : 0;

				$stmt = $conn->prepare("INSERT INTO vehicle_photos (stock, filename, is_primary) VALUES (?, ?, ?)");
				$stmt->bind_param("isi", $stock, $new_filename, $is_primary);
				$stmt->execute();
				$stmt->close();
			}
		}
	}

?>
