<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!--Scripts-->
	<?php $this->load->view('includes/scripts'); ?> 

</head>


<body style="background:#292929;">
	<div>
		
	    <div style="width:100%;background: grey;">
	    	OCR Text
	    </div>

	     <textarea readonly style="width: 400px; height: 500px;"><?php echo $text; ?></textarea>

	</div>
</body>
</html>