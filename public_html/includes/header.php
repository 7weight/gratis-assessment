<header id="header">
	<section class="container">
		<div class="row">
			<div class="three columns logo">
				<a href="/"><img src="images/athens-logo.jpg" alt="Long of Athens logo" /></a>
			</div>
			<div class="nine columns main_menu">
				<div class="menu_user">
					<?php if(isset($_SESSION['name'])) : ?>
						<div class="user_hello">
							<img src="images/avatars/<?php echo $_SESSION['avatar']; ?>" alt="<?php echo $_SESSION['name']; ?>" class="avatar" />
							<span class="u_name"><?php echo $_SESSION['name']; ?></span> |
							<a href="/u_logout.php">logout</a>
						</div>
						
					<?php endif; ?>
					
					<?php if(!isset($_SESSION['usr_id'])) { ?>
						<a href="/u_login.php">login</a>
						<!-- <li><a href="/u_lost_password.php">forgot password?</a></li> -->
					<?php }else{ ?>
					<?php }; ?>
					
				</div>
				<ul>
					<li><a href="/" title="cars">home</a></li>
					<?php if(isset($_SESSION['usr_id'])) : ?>
						<li><a href="manage.php" title="cars">manage inventory</a></li>
					<?php endif; ?>
				</ul>				
			</div>
		</div>		
	</section> 
</header>

