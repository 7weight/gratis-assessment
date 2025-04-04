<?php 
    include_once 'includes/pre_header.php';
	include_once 'includes/functions.php';			
	
	// IF NOT ADMIN, REDIRECT TO LOGIN PAGE
	check_access(1);

	$title = 'Manage Inventory';
?>

<!doctype html>
<html lang="en">
<head>
	<?php include_once 'includes/head.php';?>
</head>


<body>

	<?php include_once 'includes/header.php'; ?>			


	<main>
		<section class="container">
			<div class="row car_heading">
				<div class="twelve columns">
					<h3><?php echo $title;?> - Table Layout</h3>
					<button id="addNewCar" class="openModal button ghost green">+ Add New Car</button>
				</div>
			</div>
			<div class="row inventory">
				<?php			

				    // TABLE LAYOUT
				    $q_current_inventory2 = "
						SELECT 
						    cars.*, 
						    mfg.name AS manufacturer_name,
						    `cond`.name AS `vehicle_condition`,
						    vehicle_photos.filename AS primary_photo
						FROM 
						    cars
						LEFT JOIN 
						    vehicle_photos 
						    ON vehicle_photos.stock = cars.stock 
						    AND vehicle_photos.is_primary = 1
						LEFT JOIN 
						    mfg 
						    ON mfg.id = cars.mfg
						LEFT JOIN 
						    `cond` 
						    ON `cond`.id = cars.cond
						WHERE 
						    cars.active = 1
						ORDER BY 
						    cars.id ASC;"; 

				    try {
				        $result2 = $conn->query($q_current_inventory2);
					} catch (Exception $e) {
				        error_log($e->getMessage());
				        die("The site is temporarily offline. Please check back later.");
				    }


		        	echo '
					<table class="c_table">
						<thead>
							<tr>
								<th>photo</th>
								<th>stock #</th>
								<th>cond</th>
								<th>year</th>
								<th>mfg</th>
								<th>model</th>
								<th>pkg</th>
								<th>miles</th>
								<th>price</th>
								<th>sales price</th>
								<th>Edit</th>
								<th>Archive</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>';


				    // CYCLE THROUGH THE RECORDS

				    if ($result2->num_rows > 0) {
				        while ($row = $result2->fetch_assoc()) {

							// $card_heading = $row['year'] . ' ' . $row['manufacturer_name'] . ' ' . $row['model'] . ' ' . $row['pkg'];

				        	$v_photo = '<img src="images/inventory/' . $row['primary_photo'] . '" alt="' . $row['year'] . ' ' . $row['manufacturer_name'] . ' ' . $row['model'] . ' ' . $row['pkg'] . '" class="openModal"  data-id="' . $row['stock'] . '" />';


							echo '
									<tr>
										<td class="c_photo">' . $v_photo . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">' . $row['stock'] . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">' . ucfirst($row['vehicle_condition']) . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">' . $row['year'] . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">' . $row['manufacturer_name'] . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">' . $row['model'] . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">' . $row['pkg'] . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">' . number_format($row['miles'],0) . '</td>
										<td class="openModal"  data-id="' . $row['stock'] . '">$' . number_format($row['price'],2) . '</td>';

										if(isset($row['sale_price']) && $row['sale_price'] !== '' && $row['sale_price'] > 0) {
											echo '<td class="openModal"  data-id="' . $row['stock'] . '">$' . number_format($row['sale_price'],2) . '</td>';
										}else{
											echo '<td class="openModal"  data-id="' . $row['stock'] . '"></td>';
										}
										// <td>' . $row['sales_price'] . '</td>
							echo '
										<td><a class="v_edit openModal" data-id="' . $row['stock'] . '">&#9998;&#65039;</a></td>
										<td><a class="v_archive openTBD">&#128451;</a></td>
										<td><a class="v_delete  openTBD">&#128465;&#65039</a></td>			
									</tr>
							';
				        }
						echo '								
							</tbody>
						</table>';



				    } else {
				        echo '0 results';
				    }				

				?>
			</div>
			<div class="row car_heading">
				<div class="twelve columns">
					<h3><?php echo $title;?> - Card Layout</h3>
					<button id="addNewCar" class="openModal button ghost green">+ Add New Car</button>
				</div>
			</div>
			<div class="row inventory">
				<?php 
		   
				    $q_current_inventory = "
						SELECT 
						    cars.*, 
						    mfg.name AS manufacturer_name,
						    `cond`.name AS `vehicle_condition`,
						    vehicle_photos.filename AS primary_photo
						FROM 
						    cars
						LEFT JOIN 
						    vehicle_photos 
						    ON vehicle_photos.stock = cars.stock 
						    AND vehicle_photos.is_primary = 1
						LEFT JOIN 
						    mfg 
						    ON mfg.id = cars.mfg
						LEFT JOIN 
						    `cond` 
						    ON `cond`.id = cars.cond
						WHERE 
						    cars.active = 1
						ORDER BY 
						    cars.id ASC;"; 



					// CARD LAYOUT

				    try {
				        $result = $conn->query($q_current_inventory);
					} catch (Exception $e) {
				        error_log($e->getMessage());
				        die("The site is temporarily offline. Please check back later.");
				    }
				    
				    // CYCLE THROUGH THE RECORDS
				    if ($result->num_rows > 0) {
				        while ($row = $result->fetch_assoc()) {

							$card_heading = $row['year'] . ' ' . $row['manufacturer_name'] . ' ' . $row['model'] . ' ' . $row['pkg'];

				        	$v_photo = '<img src="images/inventory/' . $row['primary_photo'] . '" alt="' . $row['year'] . ' ' . $row['manufacturer_name'] . ' ' . $row['model'] . ' ' . $row['pkg'] . '" class="openModal"  data-id="' . $row['stock'] . '" />';

				        	$v_card = '
							<div class="three columns v_card">
								<div class="vc_img_container">
									<div class="vc_price">$' . number_format($row['price'],2) . '</div>
									<div class="vc_img">' . $v_photo . '</div>
								</div>
								<div class="vc_details">
									<div class="vc_row vc_heading">
										<div class="vc_data"><h3>' . $card_heading . '</h3></div>
									</div>
									<div class="vc_row vc_cond">
										<label>Condition:</label>
										<div class="vc_data">' . ucfirst($row['vehicle_condition']) . '</div>
									</div>
									<div class="vc_row vc_stock">
										<label>Stock: </label>
										<div class="vc_data">#' . $row['stock'] . '</div>
									</div>
									<div class="vc_row vc_mileage">
										<label>Mileage: </label>
										<div class="vc_data">' . number_format($row['miles'],0) . '</div>
									</div>
									<div class="vc_row vc_price">
										<label>Retail Price: </label>
										<div class="vc_data">$' . number_format($row['price'],2) . '</div>
									</div>
							';

							if(isset($row['sale_price']) && $row['sale_price'] !== '' && $row['sale_price'] > 0) {
								$v_card .= '
									<div class="vc_row vc_savings">
										<label>Savings Up To: </label>
										<div class="vc_data red">- $' . number_format($row['price']-$row['sale_price'],2) . '</div>
									</div>
									<div class="vc_row vc_sale_price">
										<label>Sales Price: </label>
										<div class="vc_data">$' . number_format($row['sale_price'],2) . '</div>
									</div>
								';
							}else{
								$v_card .= '
									<div class="vc_row vc_savings">
										<label>&nbsp;</label>
										<div class="vc_data"></div>
									</div>
									<div class="vc_row vc_sale_price">
										<label>&nbsp;</label>
										<div class="vc_data"></div>
									</div>
								';

							}
							$v_card .= '
								</div>
								<div class="vc_buttons manage">
									<button class="v_edit button ghost openModal" data-id="' . $row['stock'] . '">Edit</button>
									<button class="v_archive button ghost openTBD">Archive</button>
									<button class="v_delete  button ghost openTBD">Delete</button>
								</div>
								
							</div>

							';

							echo $v_card;

				        }

				    } else {
				        echo '0 results';
				    }				

				?>
			</div>
		</section>
	</main>


	<!-- POPOVER MODAL CONTAINER -->
	<div id="myModal" class="modal-overlay">
	  <div class="modal-content">
	    <span class="close-button">&times;</span>
	    <div id="modalData">
	      <p>Loading...</p>
	    </div>
	  </div>
	</div>



	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.openTBD').on('click', function() {
				$('#modalData').html('<p>TBD<span>one... later</span></p>');
				$('#myModal').fadeIn();
			});


			// OPEN NEW, BLANK FORM TO ADD CAR
			$(document).on('click', '#addNewCar', function() {
				// flush the form's old content, if present
				$('#modalData').empty().html('<p>Loading form...</p>');

				$('#myModal').fadeIn();

				$.ajax({
					url: 'includes/new_record.php',
					method: 'GET',
					success: function(response) {
						// only uncomment if form is intermittently failing to load
						// console.log("Response from new_record.php:", response);
						$('#modalData').html(response);
					},
					error: function() {
						$('#modalData').html('<p>Error loading form.</p>');
					}
				});
			});


			// SAVE THE NEW CAR AND REFRESH PAGE
			$(document).on('submit', '#newCarForm', function(e) {
				e.preventDefault();

				const formData = new FormData(this);

				$.ajax({
					url: 'includes/insert_record.php',
					method: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function(response) {
						$('#saveStatus').html('<p>' + response + '</p>');
						setTimeout(function() {
							$('#myModal').fadeOut();
							location.reload();
						}, 2000);
					},
					error: function() {
						$('#saveStatus').html('<p>Error saving new car.</p>');
					}
				});
			});



			// EDIT EXISTING CAR/RECORD
			$('.openModal').on('click', function() {
				const recordId = $(this).data('id');
				$('#modalData').html('<p>Loading...</p>');
				$('#myModal').fadeIn();

				$.ajax({
					url: 'includes/get_record.php',
					method: 'POST',
					data: { id: recordId },
					success: function(response) {
						$('#modalData').html(response);
					},
					error: function() {
						$('#modalData').html('<p>Error loading record.</p>');
					}
				});
			});

		  	// EDIT/SUBMIT FORM - AJAX
			$(document).on('submit', '#editForm', function(e) {
				e.preventDefault();
				const formData = $(this).serialize();

				$.ajax({
					url: 'includes/save_record.php',
					method: 'POST',
					data: formData,
					success: function(response) {
						$('#saveStatus').html('<p>' + response + '</p>');

		      			// Set the desired delay time before page refresh
						setTimeout(function() {
							location.reload();
						}, 2000);
					},
					error: function() {
						$('#saveStatus').html('<p>Error saving data.</p>');
					}
				});
			});


			// CLOSE BUTTON
			$('.close-button, .modal-overlay').on('click', function(e) {
				if ($(e.target).is('.close-button') || $(e.target).is('.modal-overlay')) {
					$('#myModal').fadeOut();
				}
			});

			// CLOSES THE POPOVER
			$(document).on('click', '#cancelModal', function() {
				$('#editForm')[0].reset(); // resets form fields
				$('#myModal').fadeOut();
			});

			// DISABLES THE SCROLLING FUNCTION THAT CHANGED THE INPUT FIELDS' VALUES
			$(document).on('focus', 'input[type=number]', function () {
				$(this).on('wheel.disableScroll', function (e) {
					e.preventDefault();
				});
			});
			$(document).on('blur', 'input[type=number]', function () {
				$(this).off('wheel.disableScroll');
			});

		});

	</script>




</body>
</html>