<?php
	include_once 'db_conn.php';

	if (isset($_POST['stock'])) {

		$stock = intval($_POST['stock']);
		$year = $_POST['year'];
		$mfg = $_POST['mfg'];
		$model = $_POST['model'];
		$pkg = $_POST['pkg'];
		$cond = $_POST['cond'];
		$miles = $_POST['miles'];
		$price = $_POST['price'];
		$sale_price = $_POST['sale_price'];

		// OPTIONAL
		$update_query = "
			UPDATE cars SET 
				year = ?, 
				mfg = ?,
				model = ?, 
				pkg = ?, 
				cond = ?,
				miles = ?, 
				price = ?, 
				sale_price = ?
			WHERE stock = ?
		";

		$stmt = $conn->prepare($update_query);
		$stmt->bind_param("sissiiddi", $year, $mfg, $model, $pkg, $cond, $miles, $price, $sale_price, $stock);

		if ($stmt->execute()) {
			echo "Record updated successfully.";
		} else {
			echo "Error updating record.";
		}

		$stmt->close();
	}
?>
