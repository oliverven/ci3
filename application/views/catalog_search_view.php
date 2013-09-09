<html>
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
			
			<h1>Search catalogue:</h1>
			<br/>
			<form action="auth_admin/catalog_search" method="post">
				<table class="spacer_300">
					<tr><th colspan="3"></th></tr>
					<tr>
						<td class="spacer_100">
							<select name="searchBy">
								<option value="Keyword">Keyword</option>
								<option value="Author">Author</option>
								<option value="Title">Title</option>
								<option value="Subject">Subject</option>
							</select>
						</td>
						<td class="spacer_300">
							<input style="width: 250px;" type="text" name="searchTerm"/>
						</td>
						<td>
							<input type="submit" value="Submit" name="search"/>
						</td>
					</tr>
				
				</table>
			</form>

			<!-- RESULTS-->
			<?php

			

			 ?>

		</div>
	</div>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>