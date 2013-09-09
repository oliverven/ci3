<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
		<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
			<fieldset>
				<?php

					if ( $this->flexi_auth->is_privileged('View Upload Page')){
						?>
						<legend><?php echo 'Upload File';?></legend>
						<?php echo form_open_multipart('auth_admin/upload'); ?>
						<input type="file" name="userfile[]" size="100" multiple/>
						<br/><br/>
						<input type="submit" value="Upload" name="upload" class="link_button large" />
						<?php echo form_close() ?>
						<?php
					}
					else{
						echo "Sorry, you do not have the privilege to access this page.";
					}
				?>
			</fieldset>
		</div>
	</div>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

