<?php 
    include_once 'includes/pre_header.php';
	include_once 'includes/functions.php';			

	$title = 'Login';
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
			<div class="row">

				<div class="four columns">
				</div>
				<div class="four columns u_login">

					<?php 
						// SHOW LOGIN IF NO ACTIVE SESSION
						if(
							!isset($_SESSION['usr_id']) || 
							is_Null($_SESSION['usr_id'])
						) { 
					?>
					
						<h4>Dealer Access</h4>

						<?php
							$errormsg = '';

							if (isset($_POST['login'])) {
								$username = $_POST['username'];
								$password = $_POST['password'];

							    // Add your authentication logic here
							    // Example: if authentication fails
								if ($username != 'correctUsername' || $password != 'correctPassword') {
									$errormsg = 'Invalid username or password. Passwords are case sensitive.';
								} else {
							        $_SESSION['usr_id'] = $username; // Or the appropriate user ID
							        header("Location: a_members.php"); // Redirect to a protected page
							        exit;
							    }
							}				
							if (isset($_GET['message'])) {
								if ($_GET['message'] == 'password_reset_success') {
									echo '<p style="color: green;">Your password has been reset successfully. Please login now with your new password.</p>';
								} elseif ($_GET['message'] == 'password_reset_failed') {
									echo '<p style="color: red;">Failed to reset password. Please try again later.</p>';
								} elseif ($_GET['message'] == 'invalid_token') {
									echo '<p style="color: red;">Invalid or expired token.</p>';
								}
							}

						
						?>			
					
						<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform" id="loginform">
						    <div id="login">
						        <div class="login_left">
						            <fieldset>
										<?php
							            	if (isset($_GET['message'])) {
							            		if ($_GET['message'] == 'check_email') {
							            			echo '<p class="alert green">A recovery email has been sent.<br />Please check your inbox.</p>';
							            		} elseif ($_GET['message'] == 'email_failed') {
							            			echo '<p style="color: red;">Failed to send recovery email. Please try again later.</p>';
							            		} elseif ($_GET['message'] == 'email_not_found') {
							            			echo '<p style="color: red;">Email address not found.</p>';
							            		}
											}
						            	?>
						                <div class="form-group">
						                    <label for="name">Username</label>
						                    <input type="text" name="username" placeholder="your email" class="form-control" />
						                </div>
						                <div class="form-group">
						                    <label for="name">Password</label>
						                    <input type="password" name="password" placeholder="*********" required class="form-control" />
						                </div>
						                <div class="form-group">
						                	<?php 
						                		if(isset($errormsg) && $errormsg !== '') { 
						                			echo '<div id="messageContainer">' . $errormsg . '</div>'; 
						                		}
						                	?>
						                </div>

						                <div class="form-group submit">
						                    <input type="submit" name="login" value="login" placeholder="Password" class="btn btn-primary" />
						                </div>

						                <div class="form-group lost_password">
						                    <!-- <a href="u_lost_password.php">lost password?</a> -->
						                </div>
						            </fieldset>

						        </div>
						    </div>
						</form>

						<p>
							<em class="tiny">test login credentials</em><br />
							<strong>username</strong>: test@me.com<br />
							<strong>password</strong>: gratis
						</p>
						
					<?php 
						} else {
							echo '<a href="u_logout.php">logout</a>';
						};
					?>

				</div>
				<div class="four columns">
				</div>
			</div>


		</section>
	</main>



</body>
</html>