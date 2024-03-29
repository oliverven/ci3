<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>SU Library Digitized Collections</title>
	<meta name="description" content="flexi auth, the user authentication library designed for developers."/> 
	<meta name="keywords" content="demo, flexi auth, user authentication, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="insert_address">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Intro Content -->
	<div class="content_wrap intro_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Public: Insert New Address</h2>
				<p>The flexi auth library allows multiple custom user data tables to be related to the libraries user account table.</p>
				<p>As an example of this, this demo includes a user address book that can be used by each user to save addresses and relate them to their account.</p>
				<p>This page will insert a new address to the current logged in users address book.</p>
			</div>		
		</div>
	</div>
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Insert New Address</h2>
				<a href="<?php echo $base_url;?>auth_public/manage_address_book">Manage Address Book</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>
					<fieldset>
						<legend>Address Alias</legend>
						<ul>
							<li class="info_req">
								<label for="alias">Alias:</label>
								<input type="text" id="alias" name="insert_alias" value="<?php echo set_value('insert_alias');?>" class="tooltip_trigger"
									title="An alias to reference the address by."
								/>
							</li>
						</ul>
					</fieldset>
					
					<fieldset>
						<legend>Recipient Details</legend>
						<ul>
							<li class="info_req">
								<label for="recipient">Recipient Name:</label>
								<input type="text" id="recipient" name="insert_recipient" value="<?php echo set_value('insert_recipient');?>"/>
							</li>
							<li class="info_req">
								<label for="phone_number">Phone Number:</label>
								<input type="text" id="phone_number" name="insert_phone_number" value="<?php echo set_value('insert_phone_number');?>"/>
							</li>
						</ul>
					</fieldset>
					
					<fieldset>
						<legend>Address Details</legend>
						<ul>
							<li>
								<label for="company">Company:</label>
								<input type="text" id="company" name="insert_company" value="<?php echo set_value('insert_company');?>"/>
							</li>
							<li class="info_req">
								<label for="address_01">Address 01:</label>
								<input type="text" id="address_01" name="insert_address_01" value="<?php echo set_value('insert_address_01');?>"/>
							</li>
							<li>
								<label for="address_02">Address 02:</label>
								<input type="text" id="address_02" name="insert_address_02" value="<?php echo set_value('insert_address_02');?>"/>
							</li>
							<li class="info_req">
								<label for="city">City / Town:</label>
								<input type="text" id="city" name="insert_city" value="<?php echo set_value('insert_city');?>"/>
							</li>
							<li class="info_req">
								<label for="county">State / County:</label>
								<input type="text" id="county" name="insert_county" value="<?php echo set_value('insert_county');?>"/>
							</li>
							<li class="info_req">
								<label for="post_code">Post Code:</label>
								<input type="text" id="post_code" name="insert_post_code" value="<?php echo set_value('insert_post_code');?>"/>
							</li>
							<li class="info_req">
								<label for="country">Country:</label>
								<input type="text" id="country" name="insert_country" value="<?php echo set_value('insert_country');?>"/>
							</li>
						</ul>
					</fieldset>
							
					<fieldset>
						<legend>Insert New Address</legend>
						<ul>
							<li>
								<h6>Important Note</h6>
								<small>The data saved via this demo is available for anyone else using the demo to see, therefore, it is recommended you do not include any personal details. All data that is saved via this demo, is completely wiped every few hours.</small>
							</li>
							<li>
								<hr/>
								<label for="submit">Insert Address:</label>
								<input type="submit" name="insert_address" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close();?>
			</div>
		</div>
	</div>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>