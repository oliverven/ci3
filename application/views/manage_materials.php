<!doctype html>
<html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>SU Library Digitized Collections</title>
	<?php $this->load->view('includes/head'); ?> 

</head>

<body id="list_users">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Manage Materials</h2>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open("auth_admin/manage_materials"); ?>
				<a href="add_material">Add New Material</a>
					<table>
						<thead>
							<tr>
								<th>Directory Link</th>
								<th class="spacer_250 align_ctr">Description</th>
								<th class="spacer_100 align_ctr">Material Type</th>
								<th class="spacer_100 align_ctr">Assign Tags</th>
								<th class="spacer_100 align_ctr">Delete</th>
							</tr>
						</thead>
					<?php if ($materials->num_rows != 0) { ?>
						<tbody>
						<?php foreach ($materials->result() as $material) { ?>
							<tr>
								<td>
									<?php echo $material->directory_link; ?>
								</td>
								<td class="align_ctr">
									<?php echo $material->description; ?>
								</td>
								<td class="align_ctr">
									<?php
										echo $material->material_type;
									?>
								</td>
								<td class="align_ctr">
									<a href="assign_marc_tags/<?php echo $material->material_id."/".$material->material_type_id; ?>">Manage</a>
								</td>
								<td class="align_ctr">
									<input type="checkbox" name="files[<?php echo $material->material_id; ?>]" />
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<?php $disable = (! $this->flexi_auth->is_privileged('Delete Materials') ) ? 'disabled="disabled"' : NULL;?>
									<input type="submit" name="submit" value="Delete Materials" class="link_button large" <?php echo $disable; ?>/>
								</td>
							</tr>
						</tfoot>
					<?php } else { ?>
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
	</div>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>