<?php

	echo "
	<form id='newCarForm' enctype='multipart/form-data'>
		<div class='full_width'>
			<label>ADD NEW VEHICLE</label>
		</div>
		
		<div class='new_col'>
			<label>Stock Number:</label>
			<input type='text' name='stock'><br>

			<label>VIN:</label>
			<input type='text' name='vin'><br>

			<label>Year:</label>
			<input type='text' name='year'><br>

			<label>Manufacturer:</label>
			<select name='mfg'>
				<option value='8'>BMW</option>
				<option value='6'>Chevrolet</option>
				<option value='3'>Ford</option>
				<option value='11'>GMC</option>
				<option value='4'>Honda</option>
				<option value='5'>Hyundai</option>
				<option value='10'>Kia</option>
				<option value='9'>Mercedes-Benz</option>
				<option value='7'>Nissan</option>
				<option value='1'>Toyota</option>
				<option value='2'>Volkswagen</option>				
			</select><br />

			<label>Model:</label>
			<input type='text' name='model'><br>

			<label>Package:</label>
			<input type='text' name='pkg'><br>

			<label>Condition:</label>
			<select name='cond'>
				<option value='1'>New</option>
				<option value='2'>Used</option>
				<option value='3'>Certified</option>
			</select><br />

			<label>Miles:</label>
			<input type='number' name='miles'><br>
		</div>
		<div class='new_col'>
			<label>Price:</label>
			<input type='number' step='0.01' name='price'><br>

			<label>Sale Price:</label>
			<input type='number' step='0.01' name='sale_price'><br>

			<hr>
			<label>Photo 1:</label>
			<input type='file' name='photo1'><br>
			<label class='chk_primary'><input type='checkbox' name='primary1' value='1'> Primary?</label><br>

			<label>Photo 2:</label>
			<input type='file' name='photo2'><br>
			<label class='chk_primary'><input type='checkbox' name='primary2' value='1'> Primary?</label><br>

			<label>Photo 3:</label>
			<input type='file' name='photo3'><br>
			<label class='chk_primary'><input type='checkbox' name='primary3' value='1'> Primary?</label><br>

			<button type='submit' class='green'>Add Car</button>
			<!--button type='button' id='cancelModal'>Cancel</button-->
		</div>
	</form>
	<div id='saveStatus'></div>
	";
?>
