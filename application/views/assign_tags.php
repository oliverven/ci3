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
				<h2>Material Marc Tags</h2>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open("auth_admin/assign_marc_tags/".$this->uri->segment(3)."/".$this->uri->segment(4)); ?>
				<a href="<?php echo base_url(); ?>auth_admin/addTags/<?php echo $this->uri->segment(3)."/".$this->uri->segment(4); ?>">Assign a Value to a Tag</a> | <a href="<?php echo base_url(); ?>auth_admin/manage_materials">Manage Materials</a>
					<table>
						<thead>
							<tr>
								<th class="spacer_100">Marc Tag #</th>
								<!--<th class="spacer_100 align_ctr">Description</th>-->
								<th class="spacer_100 align_ctr">Value</th>
								<th class="spacer_100 align_ctr">Delete</th>
							</tr>
						</thead>
					<?php if ($tags) { ?>
						<tbody>
						<?php foreach ($tags as $tag) { ?>
							<tr>
								<td class="align_ctr">
									<?php echo $tag->marc_tag_id; ?>
								</td>
								<!--<td class="align_ctr">
									<?php
										echo $tag->description;
									?>
								</td>
								-->
								<td class="align_ctr">
									<?php
										echo $tag->tag_value;
									?>
								</td>
								<td class="align_ctr">
									<input type="checkbox" name="files[<?php echo $tag->material_tag_values_id; ?>]" />
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<?php $disable = (! $this->flexi_auth->is_privileged('Delete Materials') ) ? 'disabled="disabled"' : NULL;?>
									<input type="submit" name="submit" value="Delete Tags" class="link_button large" <?php echo $disable; ?>/>
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