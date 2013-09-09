<script>
	// Hide content onload, prevents JS flicker
	document.body.className += ' js-enabled';
</script>

<div id="header_wrap">
	<div id="header">
		<h1 id="logo">
			<a href="<?php echo $base_url; ?>" style="color: white; font-size: 40px;">
				SU Library Digitized Collections
			</a>
		</h1>

		<h3 style="color: white; float:right; margin-top: 50px">Welcome, <?php echo $this->flexi_auth->get_user_identity() . "."; ?></h3>
	</div>
</div>