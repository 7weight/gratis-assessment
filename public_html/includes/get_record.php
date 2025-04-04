<?php
include_once 'db_conn.php';

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);

	$sel_query = "
		SELECT 
			cars.year AS `year`,
			cars.mfg AS `mfg`,
			cars.model AS `model`,
			cars.pkg AS `pkg`,
			cars.cond AS `cond`,
			`cond`.name AS `vehicle_condition`,
			cars.miles AS `miles`,
			cars.price AS `price`,
			cars.sale_price AS `sale_price`			
		FROM 
			cars
		LEFT JOIN `cond` ON `cond`.id = cars.cond
		WHERE stock = ?";

	$stmt = $conn->prepare($sel_query);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($year, $mfg, $model, $pkg, $cond, $vehicle_condition, $miles, $price, $sale_price);

	if ($stmt->fetch()) {
		echo "
		<form id='editForm'>
			<div class='full_width'>
				<label>Stock # $id</label>
			</div>
			<div class='new_col'>
				<input type='hidden' name='stock' value='$id'>
				
				
				<label>Year:</label>
				<input type='text' name='year' value='$year'><br>
				
				<label>Manufacturer:</label>
				<!--input type='text' name='mfg' value='$ mfg'><br-->
				<select name='mfg'>
					<option value='8' " . ($mfg == 8 ? "selected" : "") . ">BMW</option>
					<option value='6' " . ($mfg == 6 ? "selected" : "") . ">Chevrolet</option>
					<option value='3' " . ($mfg == 3 ? "selected" : "") . ">Ford</option>
					<option value='11' " . ($mfg == 11 ? "selected" : "") . ">GMC</option>
					<option value='4' " . ($mfg == 4 ? "selected" : "") . ">Honda</option>
					<option value='5' " . ($mfg == 5 ? "selected" : "") . ">Hyundai</option>
					<option value='10' " . ($mfg == 10 ? "selected" : "") . ">Kia</option>
					<option value='9' " . ($mfg == 9 ? "selected" : "") . ">Mercedes-Benz</option>
					<option value='7' " . ($mfg == 7 ? "selected" : "") . ">Nissan</option>
					<option value='1' " . ($mfg == 1 ? "selected" : "") . ">Toyota</option>
					<option value='2' " . ($mfg == 2 ? "selected" : "") . ">Volkswagen</option>				
				</select><br />
				
				<label>Model:</label>
				<input type='text' name='model' value='$model'><br>
				
				<label>Package:</label>
				<input type='text' name='pkg' value='$pkg'><br>

				<label>Condition:</label>
				<!--input type='text' name='vehicle_condition' value='$ vehicle_condition'><br-->
				<select name='cond'>
					<option value='1' " . ($cond == 1 ? "selected" : "") . ">New</option>
					<option value='2' " . ($cond == 2 ? "selected" : "") . ">Used</option>
					<option value='3' " . ($cond == 3 ? "selected" : "") . ">Certified</option>
				</select><br />

			</div>
			<div class='new_col'>
	
				
				<label>Miles:</label>
				<input type='number' name='miles' value='$miles'><br>
				
				<label>Price:</label>
				<input type='number' name='price' value='$price'><br>
				
				<label>Sale Price:</label>
				<input type='number' name='sale_price' value='$sale_price'><br>

				<label>Photos:</label>
				tbd<br><br><br>

				
				<button type='submit' class='green'>Save</button>
				<button type='button' id='cancelModal'>Cancel</button>
			</div>

		</form>
		<div id='saveStatus'></div>
		";
	} else {
		echo "<p>No record found.</p>";
	}

	$stmt->close();
}
?>
