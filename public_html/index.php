<?php 
    include_once 'includes/pre_header.php';
	include_once 'includes/functions.php';			

	$title = 'Home';
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
				<h3>Current Inventory</h3>
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

				        	$v_photo = '<a href="#" class="openTBD"><img src="images/inventory/' . $row['primary_photo'] . '" alt="' . $row['year'] . ' ' . $row['manufacturer_name'] . ' ' . $row['model'] . ' ' . $row['pkg'] . '" /></a>';

				        	$v_card = '
							<div class="three columns v_card">
								<div class="vc_img_container">
									<div class="vc_price">$' . number_format($row['price'],2) . '</div>
									<div class="vc_img">' . $v_photo . '</div>
								</div>
								<div class="vc_details">
									<div class="vc_row vc_mfg">
										<div class="vc_data"><h6>' . $row['manufacturer_name'] . '</h6></div>
									</div>
									<div class="vc_row vc_heading">
										<div class="vc_data"><h3><a href="#" class="openTBD">' . $card_heading . '</a></h3></div>
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
								<div class="vc_buttons">
									<button class="trade_val button ghost openTBD">Value Your Trade</button>
									<button class="cal_pmt button ghost openTBD">Calculate Your Payment</button>
									<button class="test_drive button ghost openTBD">Schedule a Test Drive</button>
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



	<div id="myModal" class="modal-overlay">
	  <div class="modal-content sm_pop">
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
				$('#modalData').html('<p>TBD<span>one... just not today</span></p>');
				$('#myModal').fadeIn();
			});



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

		});
	</script>


</body>
</html>