<html lang="en" class="no-js"><!--<![endif]-->
<head>
	<title>SU Library Digitized Collections</title>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="manage_privileges">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
		
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Manage Material Marc Tags</h2>
				<a href="<?php echo $base_url;?>auth_admin/add_material_marc?id=<?php echo $this->input->get('id')?>">Insert New Material Marc Tag</a> |
				<a href="<?php echo $base_url;?>auth_admin/manage_material_type">Manage Material Types</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url()."?id=".$this->input->get('id'));?>  	
					<table>
						<thead>
							<tr>
								<th class="spacer_500" >
									Marc Tag #
								</th>
								<th>
									Subfield
								</th>
								<th class="spacer_100 align_ctr">
									Delete
								</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if (isset($marc_tags) && count($marc_tags) >0) {	?>
						<tbody>
							<?php foreach( $marc_tags as $tag) { ?>
								<tr>
									<td><a href="<?php echo $base_url; ?>auth_admin/edit_material_marc_tag/<?php echo $tag->mm_tag_id; ?>"><?php echo $tag->marc_tag_id; ?></a></td>
									<td><?php echo $tag->subfield; ?></td>
									<td class="align_ctr"> <input type="checkbox" name="material_tags[<?php echo $tag->mm_tag_id; ?>]"/></td>
								</tr>
							<?php
							} ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<?php $disable = (! $this->flexi_auth->is_privileged('Delete Material Type Marc') ) ? 'disabled="disabled"' : NULL;?>
									<input type="submit" name="submit" value="Delete Materials" class="link_button large" <?php echo $disable; ?>/>
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