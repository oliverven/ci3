<html lang="en" class="no-js"><!--<![endif]-->
<head>
	<title>SU Library Digital Arkheion - Login Page</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/loginform/css/login_css.css" />
</head>
<body>

<div class = "container">

	<!-- MESSAGE BAR-->
	<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>

	<!-- Main Content -->
	<section class="main">
		<?php echo form_open(current_url(), 'class="form-2"');?>
			<h1><span class="log-in">Log in</span></h1> 
				<p class="float"> 	
					<label for="login_identity"><i class="icon-user"></i>Username</label>
					<input type="text" id="identity" name="login_identity" value="<?php echo set_value('login_identity', 'admin');?>"/>
				</p>
				<p class="float2"> 	
					<label for="login_password"><i class="icon-user"></i>Password</label>
					<input type="password" id="password" name="login_password" value="<?php echo set_value('login_password', 'password123');?>"/>
				</p>
				<p class="clearfix">
					<input type="submit" name = "login_user" id="submit" value="Submit" />
					<input type="submit" name = "cancel" id = "submit" value="Cancel" />
 				</p>

		<?php echo form_close();?>
	</section>


</div>

</body>
</html>