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
				<h2><?php echo $page_title;?></h2>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url()); ?>
					<table>
						<thead>
							<tr>
								
								<th>First Name</th>
								<th>Last Name</th>
								<th class="spacer_200">Email</th>
								<th class="spacer_125 align_ctr tooltip_trigger"
									title="Indicates the user group the user belongs to.">
									User Group
								</th>
								<th class="spacer_125 align_ctr tooltip_trigger" 
									title="Indicates whether the users account is currently set as 'active'.">
									Status
								</th>
							</tr>
						</thead>
					<?php if (! empty($users)) { ?>
						<tbody>
						<?php foreach ($users as $user) { ?>
							<tr>
								<td>
									<?php echo $user['upro_first_name'];?>
								</td>
								<td>
									<?php echo $user['upro_last_name'];?>
								</td>
								<td>
									<a href="<?php echo $base_url;?>auth_admin/update_user_account/<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>">
										<?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?>
									</a>
								</td>
								<td class="align_ctr">
									<?php echo $user[$this->flexi_auth->db_column('user_group', 'name')];?>
								</td>
							<?php if (isset($status) && $status == 'failed_login_users') { ?>
								<td class="align_ctr">
									<?php echo $user[$this->flexi_auth->db_column('user_acc', 'failed_logins')];?>
								</td>
							<?php } ?>
								<td class="align_ctr">
									<?php echo ($user[$this->flexi_auth->db_column('user_acc', 'active')] == 1) ? 'Active' : 'Inactive';?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="<?php echo (isset($status) && $status == 'failed_login_users') ? '6' : '5'; ?>" class="highlight_red">
									No users are available.
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