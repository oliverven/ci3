	<div class="content_wrap nav_bg">
		<div id="sub_nav_wrap" class="content">
			<ul id="sub_nav">
				<li>
					<a href="<?php echo base_url()?>">Home</a>
				</li>
				<li class="css_nav_dropmenu">
					<a href="<?php echo $base_url;?>auth_admin/">User Management</a>
					<ul>
						<li>
							<a href="<?php echo $base_url;?>auth_admin/manage_user_accounts">Manage Patron Accounts</a>			
						</li>
						<li>
							<a href="<?php echo $base_url;?>auth_admin/manage_user_groups">Manage Patron Groups</a>			
						</li>
						<li>
							<a href="<?php echo $base_url;?>auth_admin/manage_privileges">Manage Patron Privileges</a>			
						</li>
	
					</ul>		
				</li>
				
				<li class="css_nav_dropmenu">
					<a href="<?php echo $base_url;?>auth_admin/">File Management</a>
					<ul>
						<li>
							<a href="<?php echo $base_url;?>auth_admin/upload">Upload</a>
						</li>
						<li>
							<a href="<?php echo $base_url;?>auth_admin/manage_files">Manage Files</a>
						</li>

					</ul>
				</li>
				<li class="css_nav_dropmenu">
					<a href="<?php echo $base_url;?>auth_admin/">Cataloging</a>
					<ul>
						<li>
							<a href="<?php echo $base_url;?>auth_admin/manage_material_type">Manage Material Types</a>
						</li>
						<li>
							<a href="<?php echo $base_url;?>auth_admin/manage_materials">Manage Materials</a>
						</li>
					</ul>
				</li>

				<!-- LOGOUT-->
				<?php if ( $this->flexi_auth->is_logged_in()) { ?>
				<li>
					<a href="<?php echo $base_url;?>auth/logout">Logout</a>
				</li>
				<?php } ?>

				<?php
					if ($this->flexi_auth->is_privileged('Change Own Password')){
						echo '<li style="float:right;" class="css_nav_dropmenu">';
						echo	"<a href='change_password/" . $this->flexi_auth->get_user_identity() . "'>Change Password</a>";
						echo '</li>';
					}
				?>

		</div>
	</div>