<!doctype html>
<html lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>SU Library Digitized Collections</title>
	<meta name="description" content="flexi auth, the user authentication library designed for developers."/> 
	<meta name="keywords" content="demo, flexi auth, user authentication, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>
	
	$(document).ready(function(){
		
		$("#directory_link_id").change(function(){
			var key =(this.value);
			if(key == ''){
				$('#pages_from').empty();
				$('#pages_to').empty();
			}
			var employerr = jQuery.parseJSON($('#my_text_area').val());
		var i=0;
		for(i=0;i<10000;i++)
		{
			if(employerr[i].firstName==key)
			{

				var abcd = employerr[i].lastName;
				var j=0;
				var k;
				for(j=0;j<abcd;j++)
				{
					k += '<option value="'+(j+1)+'" >'+(j+1)+'</option>';
				}
				$('#pages_from').append(k);
				$('#pages_to').append(k);
			}
		}
		 
		});
	});
	</script>
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
				<h2>Add New Material</h2>
				<a href="<?php echo $base_url;?>auth_admin/manage_materials">Manage Materials</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	

					if ($files && $material_types){ ?>

					<?php
						foreach($files->result() as $file){
						$files_value[] = array(
								"firstName"=>$file->directory_link_id,
								"lastName"=>$file->num_pages
							);						
						}
					?>
                     	<textarea style="display:none" name="my_text_area" id="my_text_area"><?php echo json_encode($files_value); ?></textarea>
						<fieldset>
							<legend>Material Details</legend>
							<ul>
								<li class="info_req">
									<label for="directory_link_id">File:</label>
									<select name="directory_link_id" id="directory_link_id">
                                    <option value="">-- select file --</option> 
										<?php 
											foreach($files->result() as $file){
												echo "<option value='".$file->directory_link_id."'>$file->directory_link</option>";
											}
										?>
									</select>
								</li>
								<li class="info_req">
									<label for="material_type_id">Material Type:</label>
									<select name="material_type_id" id="material_type_id">
										<?php 
											foreach($material_types->result() as $mat_type){
												echo "<option value='".$mat_type->material_type_id."'>$mat_type->material_type</option>";
											}

										?>
									</select>
								</li>
								<li>
									<label for="material_description">Description</label>
									<input style="width: 200px;" type="text" name="mat_desc"/>
								</li>
								
							</ul>
						</fieldset>

						<fieldset>
							<legend>Add New Material</legend>
							<ul>
								<li>
									<label for="submit">Insert Material:</label>
									<input type="submit" name="submit" id="submit" value="Submit" class="link_button large"/>
								</li>
							</ul>
						</fieldset>
				<?php } echo form_close();
					 ?>
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