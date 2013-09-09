<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SU Library Digitized Collections</title>
<?php $this->load->view('includes/head'); ?>
<?php $this->load->view('includes/scripts'); ?>
</head>

<body>
<h1  style="color:white;margin-right: 200px;">Marc Tag Selector</h1>
<table width="100%">

<?php
 
 	foreach($marc_block as $block){
	?>
    	<tr><td width="570px"><a block_value="0" href="JavaScript:void(0);" onclick="block(this.id);" id="<?php echo $block['block_id'];?>"> + <?php echo $block['block_id']." -&nbsp".$block['description'];?></a></td></tr>
    <?php	
		foreach($marc_tag as $tag){
			
			if($tag['block_id'] == $block['block_id']){
			?>
					<tr tag_none="<?php echo $tag['marc_tag_id'];?>" class="<?php echo "tag_".$block['block_id']; ?>" style="display:none"><td style="padding-left:25px;" width="570px"><a tag_value="0" href="JavaScript:void(0);" onclick="tag(this.id);" id="<?php echo $tag['marc_tag_id'];?>"><?php echo $tag['marc_tag_id']." -&nbsp;".$tag['description'];?></a></td></tr>	
            <?php
				foreach($marc_subfield as $sub){
						if($sub['marc_tag_id'] == $tag['marc_tag_id']){
						?>
						<tr class="<?php echo "sub_".$tag['marc_tag_id']; ?>" style="display:none">
                        <td style="padding-left:40px;" width="570px">
                        <a href="javascript:backToMain('<?php echo $base_url;?>auth_admin/add_material_marc?id=<?php echo $mat_type_id; ?>&amp;block_id=<?php echo $block['block_id']; ?>&amp;tag_id=<?php echo $tag['marc_tag_id']; ?>&amp;sub_id=<?php echo $sub['subfield'];?>')" ><input type="button" name="<?php echo $base_url;?>auth_admin/add_material_marc?id=<?php echo $mat_type_id; ?>&block_id=<?php echo $block['block_id']; ?>&tag_id=<?php echo $tag['marc_tag_id']; ?>&sub_id=<?php echo $sub['subfield'];?>" value="use"  /></a>
						<?php echo $sub['subfield']." -&nbsp;".$sub['description'];?>
                        </td>
                        </tr>	
                        <?php		
					}	
				}
			
			}		
			
		}
	
	}
 
 ?>
</table>

<script>
	function block(id){ 
		
		var display_value = $("#"+id).attr("block_value");
		var class_name = ".tag_"+id;
		
		if(display_value == '0'){
			$(class_name).css("display","block");
			$("#"+id).attr("block_value","1");
		}else{
			$(class_name).css("display","none");
			$("#"+id).attr("block_value","0");
			tag_no($(class_name).attr("tag_none"));
		}
		
	}
	function tag_no(id){
		
		var class_name = ".sub_"+id;
		
		$(class_name).css("display","none");
		$("#"+id).attr("tag_value","0");
		
	}
	
	function tag(id){
		var tag_value = $("#"+id).attr("tag_value");
		var class_name = ".sub_"+id;
		
		if(tag_value == '0'){
			$(class_name).css("display","block");
			$("#"+id).attr("tag_value","1");
		}else{
			$(class_name).css("display","none");
			$("#"+id).attr("tag_value","0");
		}
	}
	
	function backToMain(URL) {
		var mainWin;
		mainWin = window.open(URL,"main");
		mainWin.focus();
		this.close();
}
	
</script>



</body>
</html>