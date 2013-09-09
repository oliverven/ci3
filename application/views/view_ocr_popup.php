<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!--Scripts-->
	<?php $this->load->view('includes/scripts'); ?> 


	<script>

	function showonlyone(thechosenone) {
      var newboxes = document.getElementsByTagName("div");
            for(var x=0; x<newboxes.length; x++) {
                  name = newboxes[x].getAttribute("class");
                  if (name == 'newboxes') {
                        if (newboxes[x].id == thechosenone) {
                        newboxes[x].style.display = 'block';
                  }
                  else {
                        newboxes[x].style.display = 'none';
                  }
            }
      }
   }

   function makeEditable(id){
     var el = document.getElementById(id);
     el.disabled = false;
   }

	</script>

</head>


<body style="background:#292929;">
	<div>
	    <div style="width:100%;background: grey;">
	    	<h3><?php echo $page_title ?></h3
	    </div>
       <div style="background: white; width: 100%;">
       Pages:
       <?php 

         
         for($i=0;$i<count($ocr_text);$i++){
            $t = $i + 1;
            ?>
               <a id="myHeader<?php echo $i?>" href="javascript:showonlyone('newboxes<?php echo $i?>');" ><?php echo $t ?></a>
            <?php
         }

         echo "</div><br/>";
         //TEXTAREAS
         for($i = 0;$i<count($ocr_text);$i++){
            ?>
            <form action="<?php echo base_url();?>auth_admin/save_changes" method="post">
            
            <?php if ($i==0){
               ?>
               
                  <div class="newboxes" id='newboxes<?php echo $i ?>' style='display:block'><textarea name="ocr_text" id='txt<?php echo $i ?>' disabled style="width:500px; height: 350px;"><?php echo htmlspecialchars($ocr_text[$i]->ocr_text); ?></textarea>
                     <br/><input type="button" onclick="makeEditable('txt<?php echo $i ?>')" value="Edit"/>
                     <input name="file_ocr_text_id" type="hidden" value="<?php echo $ocr_text[$i]->file_ocr_text_id; ?>"/>
                     <input type="submit" value="Save Changes"/>
                  </div>
               </form>
               <?php
            }
            else{
               ?>
               <div class="newboxes" id='newboxes<?php echo $i ?>' style='display:none'><textarea id='txt<?php echo $i ?>' name="ocr_text" disabled style="width:500px; height: 350px;"><?php echo htmlspecialchars($ocr_text[$i]->ocr_text); ?></textarea>                
                  <br/><input type="button" onclick="makeEditable('txt<?php echo $i ?>')" value="Edit"/>

                     <input name="file_ocr_text_id" type="hidden" value="<?php echo $ocr_text[$i]->file_ocr_text_id; ?>"/>
                     <input type="submit" value="Save Changes"/>
               </div>
               </form>
               <?php

            }
         }

      ?>
      <input style="" type="button" value="Print" onclick="window.print()" />
</body>
	</div>
</body>
</html>