<html>
<head>
	
	<title>SU Library Digitized Collections</title>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="admin_dashboard">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<h2>Material Types</h2>
			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
			<?php echo form_open(current_url()."?id=".$this->input->get('id')); ?>
				<a href="<?php echo base_url();?>auth_admin/manage_material_type">Manage Material Types</a>
				<fieldset>
						<legend>Material Type Details</legend>
						<ul>
							<input type="hidden" name="material_type_id" value="<?php echo $file->material_type_id; ?>"/>
							<li class="info_req">
								<label for="material_type">Material Type:</label>
								<input type="text" id="material_type" value="<?php echo $file->material_type; ?>" name="material_type" />
							</li>
							<li>
								<label for="description">Description:</label>
								<textarea id="description" name="description" class="width_400"><?php echo $file->description; ?></textarea>
							</li>
							<li>
								<label for="printable">Printable</label>
								<input <?php if ($file->printable == 1) echo "checked"; ?> class="tooltip_trigger" type="checkbox" name="printable" id="printable" title="Checking this box would allow this material type to be printable. Default: Checked" />
							</li>
						</ul>
					</fieldset>

					<fieldset>
						<legend>Add New Material Type</legend>
						<ul>
							<li>
								<label for="submit">Insert Material:</label>
								<input type="submit" name="edit_material" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				
			<?php echo form_close(); ?>
		</div>
	</div>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>