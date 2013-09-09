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
			
			<?php echo form_open(current_url()); ?>
				<a href="add_material">Add New Material Type</a>
				<table>
					<thead>
						<tr>
							<th>Material Types</th>
							<th>Description</th>
							<th class="align_ctr spacer_100">MARC Tags</th>
							<th class="align_ctr spacer_100">Delete</th>
						</tr>
					</thead>
					<?php 
					if (isset($files) && $files->num_rows != 0) {	?>
						<tbody>
							<?php foreach( $files->result() as $file) { ?>
								<tr>
									<td><a href="<?php echo $base_url; ?>auth_admin/edit_material?id=<?php echo $file->material_type_id; ?>"><?php echo $file->material_type; ?></a></td>
									<td><?php echo $file->description; ?></td>
									<td class="align_ctr"><a href="<?php echo $base_url; ?>auth_admin/manage_material_marc?id=<?php echo $file->material_type_id; ?>">Manage</a></td>
									<td class="align_ctr"> <input type="checkbox" name="files[<?php echo $file->material_type_id; ?>]"/></td>
								</tr>
							<?php
							} ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<?php $disable = (! $this->flexi_auth->is_privileged('Delete Materials') ) ? 'disabled="disabled"' : NULL;?>
									<input type="submit" name="delete_materials" value="Delete Materials" class="link_button large" <?php echo $disable; ?>/>
								</td>
							</tr>
						</tfoot>
					<?php } else{ ?>
						<tbody>
							<tr>
								<td colspan="<?php echo (isset($status) && $status == 'failed_login_users') ? '6' : '5'; ?>" class="highlight_red">
									No files are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
				</table>
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