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

<body id="register">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Assign a value to a Tag</h2>
				<a href="<?php echo $base_url;?>auth_admin/manage_materials">Manage Material</a>
			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url()); if($tags){ ?>  	
					<fieldset>
						<legend>Marc Tags:</legend>
						<ul>

							<?php
							foreach($tags as $tag){
								?>
								<li>
									<label for="tags"><?php echo $tag->marc_tag_id. " :  ". $tag->description ?></label>
									<input type="text" id="tags" name="tags[<?php echo $tag->marc_tag_id ?>]"/>
								</li>
							<?php }?>

						</ul>
					</fieldset>
					<input type="hidden" name="directory_link_id" value="<?php echo $tags[0]->directory_link_id; ?>" />
					<input type="submit" name="submit" id="submit" value="Submit" class="link_button large"/>
				<?php echo form_close();}
				else{
								echo "<h4>You must assign a Marc Tag to a Material Type First. <br/> Click <a href='". base_url()."auth_admin/manage_material_type'>Here</a></h4>";}?>
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