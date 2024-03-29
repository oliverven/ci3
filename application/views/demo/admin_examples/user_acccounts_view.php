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

<body id="manage_users">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 

	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>User Accounts</h2>


			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>
					<fieldset>
						<legend>Search Filter</legend>
						
						<label for="search">Search Users:</label>
						<input type="text" id="search" name="search_query" value="<?php echo set_value('search_users',$search_query);?>"/>
						<input type="submit" name="search_users" value="Search" class="link_button"/>
						<a href="<?php echo $base_url; ?>auth_admin/manage_user_accounts" class="link_button grey">Reset</a>
						
					</fieldset>
				<?php echo form_close();?>
				<a href="./register_account">Add New User</a>
			
				<?php echo form_open(current_url());	?>
					<table>
						<thead>
							<tr>
								<th>Username</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th class="spacer_200">Email</th>
								<th class="spacer_100 align_ctr"
									>
									User Group
								</th>
								<th class="spacer_100 align_ctr">
									User Privileges
								</th>
								<th class="align_ctr">
									Assigned IP:
								</th>
								<th class="spacer_100 align_ctr">
									Account Suspended
								</th>
								<th class="spacer_100 align_ctr tooltip_trigger" 
									title="If checked, the row will be deleted upon the form being updated.">
									Delete
								</th>
							</tr>
						</thead>
						<?php if (!empty($users)) { ?>
						<tbody>
							<?php foreach ($users as $user) { ?>
							<tr>
								<td>
									<a href="<?php echo $base_url.'auth_admin/update_user_account/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>">
										<?php echo $user['uacc_username'];?>
									</a>
								</td>
								<td>
									<?php echo $user['upro_first_name'];?>
								</td>
								<td>
									<?php echo $user['upro_last_name'];?>
								</td>
								<td>
										<?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')];?>
								</td>
								<td class="align_ctr">
									<?php echo $user[$this->flexi_auth->db_column('user_group', 'name')];?>
								</td>
								<td class="align_ctr">
									<a href="<?php echo $base_url.'auth_admin/update_user_privileges/'.$user[$this->flexi_auth->db_column('user_acc', 'id')];?>">Manage</a>
								</td>
								<td class="align_ctr">
									<?php echo $user['assigned_ip']; ?>
								</td>
								<td class="align_ctr">
									<input type="hidden" name="current_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'suspend')];?>"/>
									<!-- A hidden 'suspend_status[]' input is included to detect unchecked checkboxes on submit -->
									<input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="0"/>
								
								<?php if ($this->flexi_auth->is_privileged('Update Patrons')) { ?>
									<input type="checkbox" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="1" <?php echo ($user[$this->flexi_auth->db_column('user_acc', 'suspend')] == 1) ? 'checked="checked"' : "";?>/>
								<?php } else { ?>
									<input type="checkbox" disabled="disabled"/>
									<small>Not Privileged</small>
									<input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="0"/>
								<?php } ?>
								</td>
								<td class="align_ctr">
								<?php if ($this->flexi_auth->is_privileged('Delete Patrons')) { ?>
									<input type="checkbox" name="delete_user[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="1"/>
								<?php } else { ?>
									<input type="checkbox" disabled="disabled"/>
									<small>Not Privileged</small>
									<input type="hidden" name="delete_user[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')];?>]" value="0"/>
								<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="8">
									<?php $disable = (! $this->flexi_auth->is_privileged('Update Patrons') && ! $this->flexi_auth->is_privileged('Delete Patrons')) ? 'disabled="disabled"' : NULL;?>
									<input type="submit" name="update_users" value="Update / Delete Users" class="link_button large" <?php echo $disable; ?>/>
								</td>
							</tr>
						</tfoot>
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="7" class="highlight_red">
									No users are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>
					</table>
					
				<?php if (! empty($pagination['links'])) { ?>
					<div id="pagination" class="w100 frame">
						<p>Pagination: <?php echo $pagination['total_users'];?> users match your search</p>
						<p>Links: <?php echo $pagination['links'];?></p>
					</div>
				<?php } ?>
					
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