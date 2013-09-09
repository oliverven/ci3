<!doctype html>
<html lang="en"><!--<![endif]-->
<head>

	<title>SU Library Digitized Collections</title>

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
				<h2>Add New Material Marc Tag</h2>
				<a href="<?php echo $base_url;?>auth_admin/manage_material_type">Manage Material Types</a> |
				<a href="<?php echo $base_url;?>auth_admin/manage_material_marc?id=<?php echo $this->input->get('id'); ?>">Manage Material Marc</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url()."?id=".$this->input->get('id'));?>  	
					<fieldset>
						<legend>Marc Tag</legend>
						<ul>
							<li>
								<label for="s_marc_block_id">Marc Block #:</label>
								<input readonly style="width:20px;" type="text" id="s_marc_block_id" name="s_marc_block_id" <?php if (isset($_REQUEST['block_id'])) echo "value='".$_REQUEST['block_id']."'" ?>/>
                                <input type="button" name="<?php echo $base_url;?>auth_admin/add_material_content/<?php echo $this->input->get('id'); ?>" value="SELECT" id="select" onClick="popup(this.name);" />
							</li>
						</ul>
						<ul>
							<li>
								<label for="s_marc_tag_id">Marc Tag #:</label>
								<input readonly style="width:40px;" type="text" id="s_marc_tag_id" name="s_marc_tag_id" <?php if (isset($_REQUEST['tag_id'])) echo "value='".$_REQUEST['tag_id']."'" ?>/>

							</li>
						</ul>
						<ul>
							<li>
								<label for="s_marc_subfield">Marc Tag Subfield:</label>
								<input readonly style="width:40px;" type="text" id="s_marc_subfield" name="s_marc_subfield" <?php if (isset($_REQUEST['sub_id'])) echo "value='".$_REQUEST['sub_id']."'" ?>/>
							</li>
						</ul>
						<input type="hidden" value="description" name="s_description"/>
						<input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="mat_id"/>
					</fieldset>

					<fieldset>
						<legend>Add New Material Type</legend>
						<ul>
							<li>
								<label for="submit">Insert New Material Marc Tag:</label>
								<input type="submit" name="submit" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close()?>
			</div>
		</div>
	</div>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 
<script>
function popup(url)
{
    myWindow=window.open(url,'secondary','location=1,status=1,scrollbars=yes,width=600,height=500');
    myWindow.focus();
    self.name="main";
}
</script>


</body>
</html>