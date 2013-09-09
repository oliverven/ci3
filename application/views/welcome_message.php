<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/text.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/960.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/page.css" />
	<?php $this->load->view('includes/scripts'); ?>
	<title>SU Library Digitized Collections</title>


	<style>

	.tooltip_trigger {cursor:help;}
		span.tooltip_trigger:after {content:"\2020"; vertical-align:7px; font-size:70%; color:#069;}

	.tooltip {
	display:none; min-width:120px; max-width:250px; padding:10px; background-color:#444; border:1px solid #222; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;
	color:#eee; box-shadow:0 2px 10px rgba(0,0,0,0.5); -webkit-box-shadow:0 2px 10px rgba(0,0,0,0.5); -moz-box-shadow:0 2px 10px rgba(0,0,0,0.5);
	-moz-opacity: 0.5;
	filter:alpha(opacity=5);
	}
	.tooltip.width_300 {max-width:300px;}
	.tooltip table {color:#333;}

	</style>
	<script>
		function popup(id)
		{
		    myWindow=window.open('welcome/view_ocr_pages/' + id,'','location=1,status=1,scrollbars=1,width=700,height=700');
		    myWindow.focus();
		}

		$(document).ready(function(){
 
	        $(".slidingDiv").hide();
	        $(".show_hide").show();
	 
		    $('.show_hide').click(function(){
		    	$(".slidingDiv").slideToggle();
	    });
 
});



	</script>
</head>
<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>

	<div class="container_16">
		<div class="grid_16">
				<div id="linetop"> 
				</div>
		</div>
		<div class="grid_16">
			<img src="<?php echo base_url(); ?>assets/images/homepage.png" width="940px" height="320px"></img>
		</div>
		<div class="grid_16">
			
							<ul id='nav'>
									
									<li><a href="/ci3">Home</a></li>
									
									<li>
										<?php
										if ($this->flexi_auth->is_privileged('Admin Dashboard')){
						
												echo anchor('auth_admin/dashboard', 'Admin', "class='nav'");
												
										}
										?>
									</li>	
									<li>
									<?php if ($this->flexi_auth->is_logged_in()){
														echo anchor('auth/logout','Logout'," class='nav'"); 
													}
													else{
														echo anchor('auth','Login'," class='nav'");
													}
									?>
									</li>
									<li>
									<div class="grid_8 push_6">
										<div id="font">
											<?php  if($this->flexi_auth->is_logged_in()) 
											  echo "Welcome, ". $this->flexi_auth->get_user_identity() . ".";
											?>
										</div>
									</div>
									</li>
							</ul>
							
					
					
		</div>
		
		
		<div class="grid_16">
				<div id="linebottom"> 
				</div>
		</div>
		<!--body contents-->
		
		
		
		<div class="grid_16" style="">
				<div id="homebody"> 
						<div id="search" style="margin-top:20px; margin-bottom:50px;">
							<form action="<?php echo base_url();?>search" method="get">
								<input title="You can search for specific keywords, or you can specify whether to search by author, title or subject by clicking on Advance Search." class="tooltip_trigger" <?php if (isset($keyword)) echo "value='$keyword'"; ?> name="keyword" type="text" style="width:450px;"/>
								<input type="submit" value="Search"/>
								<br/>
								<a href="#" class='show_hide'>Advanced Search</a><a style="margin-left: 30px;" href="./welcome">Reset</a>
								<div class="slidingDiv">
									<table>
										<tr>
											<td class="tooltip_trigger" title="Tag 100">Author</td>
											<td><input class="tooltip_trigger" type="checkbox" title="Tag 100" id='author'name="author" /><br/></td>
										</tr>
										<tr>
											<td class="tooltip_trigger" title="Tag 245">Title:</td>
											<td><input class="tooltip_trigger" type="checkbox" title="Tag 245" id='title' name="title" /><br/></td>
										</tr>
										<tr>
											<td class="tooltip_trigger" title="Tag 650">Subject:</td>
											<td><input class="tooltip_trigger" type="checkbox" title="Tag 650" id='subject' name="subject" /></td>
										</tr>
									</table>
									
								</div>
							</form>
						</div>

						
						<hr/>


						<?php 

							if (isset($files)){
								$count = 1;
								foreach($files as $index){
									foreach($index as $id => $link){
									?>
										<div>
											<?php echo $count. " . ". str_replace("_", " ", $link);?>
											<br/>
											<a href="pdf_viewer/v?file=<?php echo $link;?>&<?php if ($search_using == 'ocr') echo "keyword=$keyword"; ?>">View PDF</a>
											<br/>
											<?php 
												if ($search_using == 'ocr'){
													?>
														<a href="javascript:popup(<?php echo $id; ?>);">View OCR Text</a>


													<?php
												}
											?>
											
										</div>
									<?php
									$count++;
									}
								}
							}

							?>

				</div>


			
		</div>


			
		
		<!--body contents-->
		
		<!--footer-->
		<div class="grid_16">
				<div id="footerline"> 
				</div>
		</div>
		
		<div class="grid_16">
				<div id="footerbody"> 
				  <div id="footertitle">Copyright. SU-CCS Capstone Group-2, batch 2013. All Rights Reserved.</div>
				</div>
		</div>
		
	</div>

</html>