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

<body id="manage_user_groups">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Intro Content -->
		<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Manage User Groups</h2>
				<a href="<?php echo $base_url;?>auth_admin/insert_user_group">Insert New User Group</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<table>
						<thead>
							<tr>
								<th class="spacer_150 ">
									Group Name
								</th>
								<th>
									Description
								</th>
								<th class="spacer_100 align_ctr">
									Privileges
								</th>
								<th class="spacer_100 align_ctr">
									Delete
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($user_groups as $group) { ?>
							<tr>
								<td>
									<a href="<?php echo $base_url;?>auth_admin/update_user_group/<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')];?>">
										<?php echo $group[$this->flexi_auth->db_column('user_group', 'name')];?>
									</a>
								</td>
								<td><?php echo $group[$this->flexi_auth->db_column('user_group', 'description')];?></td>
								<td class="align_ctr"><a href="<?php echo $base_url; ?>auth_admin/manage_group_privileges/<?php echo $group[$this->flexi_auth->db_column('user_group','id')]; ?>">Manage</a></td>
								<td class="align_ctr">
								<?php if ($this->flexi_auth->is_privileged('Delete Patron Groups')) { ?>
									<input type="checkbox" name="delete_group[<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')];?>]" value="1"/>
								<?php } else { ?>
									<input type="checkbox" disabled="disabled"/>
									<small>Not Privileged</small>
									<input type="hidden" name="delete_group[<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')];?>]" value="0"/>
								<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<td colspan="4">
								<?php $disable = (! $this->flexi_auth->is_privileged('Update Patron Groups') && ! $this->flexi_auth->is_privileged('Delete User Groups')) ? 'disabled="disabled"' : NULL;?>
								<input type="submit" name="submit" value="Delete Checked User Groups" class="link_button large" <?php echo $disable; ?>/>
							</td>
						</tfoot>
					</table>
					
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