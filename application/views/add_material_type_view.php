<!doctype html>
<html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>SU Library Digitized Collections</title>
	<meta name="description" content="flexi auth, the user authentication library designed for developers."/> 
	<meta name="keywords" content="demo, flexi auth, user authentication, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="insert_privilege">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 

	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Add New Material Type</h2>
				<a href="<?php echo $base_url;?>auth_admin/manage_material_type">Manage Material Types</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<fieldset>
						<legend>Material Type Details</legend>
						<ul>
							<li class="info_req">
								<label for="material_type">Material Type:</label>
								<input type="text" id="material_type" name="material_type" />
							</li>
							<li>
								<label for="description">Description:</label>
								<textarea id="description" name="description" class="width_400"></textarea>
							</li>
							<li>
								<label for="printable">Printable</label>
								<input checked class="tooltip_trigger" type="checkbox" name="printable" id="printable" title="Checking this box would allow this material type to be printable. Default: Checked" />
							</li>
						</ul>
					</fieldset>

					<fieldset>
						<legend>Add New Material Type</legend>
						<ul>
							<li>
								<label for="submit">Insert Material Type:</label>
								<input type="submit" name="add_material" id="submit" value="Submit" class="link_button large"/>
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