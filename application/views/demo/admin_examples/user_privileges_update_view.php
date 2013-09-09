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

	<script>

	var parents = new Array( 12 , 1 , 2 , 3 , 18 , 20 , 25 , 32);

	var privileges = new Array();


	privileges[12] = [ 1 , 2 , 3 , 18 , 20 , 25 , 32];

	privileges[1] = [ 6 , 9 , 21 , 22 , 23 , 27 ];

	privileges[2] = [ 4 , 7 , 10 , 24];

	privileges[3] = [ 5 , 11];

	privileges[18] = [ 13 , 28 ];

	privileges[20] = [ ];

	privileges[25] = [ 16 , 17 , 26 , 30 ];

	privilege[32] = [];
	/*
		Children of 12
		1 , 2 , 3 , 18 , 20 , 25


	*/

	function initialize(){
		for (var i =0; i < 26 ; i++){
			if (i != 1 && i != 2 && i != 3 && i != 12 && i != 18 && i != 20 && i != 25 ){
				privileges[i] = false;
			}
		}
	}


	function performCheck(id){
		initialize();
		var flag=0;
	    for(var i = 0; i < parents.length; i++) {
	        if(parents[i] == id){
	        	toggleChildren(id);
	        	break;
	        }
	        else
	        	flag=1;
	    }
	    if (flag == 1)
	    	toggleParent(id);
	}

	function toggleParent(id){
		var flag=0;
		for (var i=0;i < privileges.length; i++){
			if (privileges[i] != false){
				for(var x = 0 ; x < privileges[i].length; x++){
					if (id == privileges[i][x])
						document.getElementById("privileges[" + i + "]").checked=true;
				}
			}
		}
	}

	function toggleChildren(id){
		for (var i = 0 ; i < privileges[id].length;i++){
			document.getElementById("privileges[" + privileges[id][i] + "]").checked=document.getElementById("privileges["+id+"]").checked;
		}
		
	}



	</script>
</head>

<body id="update_user_privileges">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
		
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Update User Privileges of <?php echo $user['upro_first_name'].' '.$user['upro_last_name']; ?></h2>
				<a href="<?php echo $base_url;?>auth_admin/manage_user_accounts">Manage User Accounts</a> | 
				<a href="<?php echo $base_url;?>auth_admin/update_user_account/<?php echo $user['upro_uacc_fk']; ?>">Update Users Account</a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
			
				<?php echo form_open(current_url());	?>  	
					<table>
						<thead>
							<tr>
								<th class="tooltip_trigger"
									title="The name of the privilege."/>
									Privilege Name
								</th>
								<th class="tooltip_trigger"
									title="A short description of the purpose of the privilege."/>
									Description
								</th>
								<th class="spacer_150 align_ctr tooltip_trigger"
									title="If checked, the user will be granted the privilege."/>
									User Has Privilege
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($privileges as $privilege) { ?>
							<tr>
								<td>
									<input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][id]" value="<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>"/>
									<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'name')];?>
								</td>
								<td><?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'description')];?></td>
								<td class="align_ctr">
									<?php 
										// Define form input values.
										$current_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $user_privileges)) ? 1 : 0; 
										$new_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $user_privileges)) ? 'checked="checked"' : NULL;
									?>
									<input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
									<input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')];?>][new_status]" value="0"/>
									<input onchange="performCheck(<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')];?>)" id="privileges[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')];?>]" type="checkbox" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/>
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">
									<input type="submit" name="update_user_privilege" value="Update User Privileges" class="link_button large"/>
								</td>
							</tr>
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