<!doctype html>
<html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>SU Library Digitized Collections</title>
	<?php $this->load->view('includes/head'); ?> 


	<script>
		function popup(url)
		{
		    myWindow=window.open('<?php echo base_url(); ?>auth_admin/view_ocr_pages/'+url,'','location=1,status=1,scrollbars=1,width=700,height=700');
		    myWindow.focus();
		}

		function executeOnSubmit()
		{
			var res = confirm("Are you sure you want to delete the file/s?");
			if(res)
				return true;
			else
				return false;
		}
	</script>
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
			<div class="col200">
				<h2><?php echo $page_title;?></h2>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>

				<?php echo form_open(current_url());	?>
					<fieldset>
						<legend>Search Filter</legend>
						
						<label for="search">Search Files:</label>
						<input type="text" id="search" name="search_query" value=""/>
						<input type="submit" name="search_files" value="Search" class="link_button"/>
						<a href="<?php echo $base_url; ?>auth_admin/manage_files" class="link_button grey">Reset</a>
						
					</fieldset>
				<?php echo form_close();?>

				<a href="./upload">Upload Files</a> <?php if ($num_rows) echo "<h6 style='float:right;'>Total Files = $num_rows.</h6>"; ?>
				
				<?php echo form_open("auth_admin/manage_files", array('onsubmit' => "return executeOnSubmit();")); ?>

					<table>
						<thead>
							<tr>
								<th>Directory Link</th>
								<th class="spacer_100 align_ctr">OCR processed</th>
								<th class="spacer_100 align_ctr">View</th>
								<!--
								<th class="spacer_100 align_ctr">Status</th>
								-->
								<th class="spacer_100 align_ctr">Uploaded By</th>
								<th class="spacer_100 align_ctr">Uploaded On</th>
								<th class="spacer_100 align_ctr">Delete</th>
							</tr>
						</thead>
					<?php if ($files) if ($num_rows != 0) { ?>
						<tbody>
						<?php foreach ($files->result() as $file) { ?>
							<tr>
								<td>
									<?php echo $file->directory_link; ?>
								</td>
								<td class="align_ctr">
									<?php if ($file->processed) 
											echo "Done";
										  else
										  	echo '<a href="perform_ocr/'.$file->directory_link_id."/".$file->directory_link.'">Perform OCR</a>';
										   ?>
								</td>
								<td class="align_ctr">
									<?php
									echo "<a href='". base_url()."pdf_viewer/v?file=$file->directory_link'>PDF</a>";
									echo " | ";
									if ($file->processed){
										?>
											<a href=""value="SELECT" id="select" onClick="popup(<?php echo $file->directory_link_id; ?>);">OCR</a>
										<?php
									}
									else
										echo " Not available.";

									?>
								</td>
								<!--
								<td class="align_ctr">
									<?php
										$str =  "<a href= './change_file_status?id=";
										$str .= $file->directory_link_id . "&to=";
										if ($file->status == "Activated")
											$str .= "deactivate";
										else
											$str .= "activate";
										$str .= "'>". $file->status ."</a>";
										echo $str;
									?>
								</td>
								-->
								<td class="align_ctr">
									<?php echo $file->uploaded_by; ?>
								</td>
								<td class="align_ctr">
									<?php echo $file->uploaded_on; ?>
								</td>
								<td class="align_ctr">
									<input type="checkbox" name="files[<?php echo $file->directory_link_id; ?>]" />
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<?php $disable = (! $this->flexi_auth->is_privileged('Delete Files') ) ? 'disabled="disabled"' : NULL;?>
									<input type="submit" name="delete_files" value="Delete Files" class="link_button large" <?php echo $disable; ?>/>
								</td>
							</tr>
						</tfoot>
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="<?php echo (isset($status) && $status == 'failed_login_users') ? '6' : '5'; ?>" class="highlight_red">
									No files are available.
								</td>
							</tr>
						</tbody>
					<?php } ?>

					</table>
					<!--
					<?php if (! empty($pagination['links'])) { ?>
					<div id="pagination" class="w100 frame">
						<p>Pagination: <?php echo $pagination['total_files'];?> users match your search</p>
						<p>Links: <?php echo $pagination['links'];?></p>
					</div>
				<?php } ?>
				-->
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