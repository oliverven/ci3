<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/text.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/960.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/page.css" />
	<title>SU Library Digitized Collections</title>
</head>

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
		
		
		
		<div class="grid_16" style="width:940px;">
				<div id="homebody">
				<h6><a href="javascript: window.history.back();">< Back</a></h6> 
						<center>
							<div class="container_12" style="text-align:center;">
								<?php 
									echo '<iframe name="sample" width="98%" height="70%" seamless scrolling="no" src="'.base_url().'pdf_viewer/web/viewer.html?file=../../uploads/'.$file;
									if (isset($page))
										echo "#$page";
									if (isset($keyword) && $keyword != "")
										echo " #search=$keyword";
									echo '"></iframe>';
								?>
			
							</div>
						</center>

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