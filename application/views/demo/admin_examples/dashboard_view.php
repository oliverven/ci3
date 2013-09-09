<html>
<head>
	
	<title>SU Library Digitized Collections</title>
	<?php $this->load->view('includes/head'); ?> 
</head>
<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
<body id="admin_dashboard">

<div id="body_wrap">
	<?php 
	// Check if you are logged in on a machine with an ip address assigned to your account
	$cur_ip = $this->input->ip_address();
 	if ($this->flexi_auth->get_user_by_identity($this->flexi_auth->get_user_identity())->result()[0]->assigned_ip != $cur_ip){
 		redirect(base_url()."auth/logout?er=invalid_ip");
 	}


	?>
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">

			<div>
			<?php 
				if ($top5){
					echo '<br/>';
					echo '<h1>Most Viewed Files:</h1>';
					$count=1;
					foreach($top5 as $top){
						echo "<h6>$count : ".str_replace("_", " ",$top->directory_link)."</h6>";
						echo "<h6>Total Views: $top->num_views</h6>";
						$count++;
					}
				}

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