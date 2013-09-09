<?php if (!defined('BASEPATH')) exit("No direct script access allowed");



class Upload_model extends CI_Model{

	var $error=false;

	public function __construct(){
		parent::__construct();
	}

	function convert_to_filename ($string) {

	  // Replace spaces with underscores and makes the string lowercase
	  $string = str_replace (" ", "_", $string);
	  $string = str_replace ("...", ".", $string);

	  // Match any character that is not in our whitelist
	  preg_match_all ("/[^0-9^a-z^A-Z^_^.]/", $string, $matches);

	  // Loop through the matches with foreach
	  foreach ($matches[0] as $value) {
	    $string = str_replace($value, "", $string);
	  }
	  return $string;
	}

	public function do_upload(){
		$directory_link = "";
		$config = array(
			'allowed_types' => 'pdf',
			'upload_path' => './uploads/',
			'remove_spaces' => FALSE,
			'max_size' => 0,
			'overwrite' => TRUE
		);
		$this->load->library('upload' , $config);
		for ($i = 0 ; $i < count($_FILES['userfile']['name']) ; $i ++){

			$_FILES['filename']['name']    = $_FILES['userfile']['name'][$i];
			//removing white spaces
			//$_FILES['filename']['name']	= str_replace(" ","_", $_FILES['filename']['name']);
			$_FILES['filename']['name']	= $this->convert_to_filename($_FILES['filename']['name']);;
		    $_FILES['filename']['type']    = $_FILES['userfile']['type'][$i];
		    $_FILES['filename']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
		    $_FILES['filename']['error']       = $_FILES['userfile']['error'][$i];
		    $_FILES['filename']['size']    = $_FILES['userfile']['size'][$i];
		    
		    $this->upload->initialize($config);

		    $directory_link = $_FILES['filename']['name'];

		    //check if already exists/has duplicate
		    if (!$this->files_model->getFileDirectoryLink($directory_link) && strtoupper($_FILES['filename']['type']) == "APPLICATION/PDF"){
		    	if (!$this->upload->do_upload('filename')){
		    		$this->error=true;
		    		break;
		    	}
		    	$num_pages=false;
		    	exec("pdfinfo uploads/$directory_link",$out);
		    	if ($out){
		    		foreach ($out as $index => $val){
		    			if (substr($val,0,5) == "Pages"){
		    				$num_pages = substr($val, 7);
		    			}
		    		}
		    	}
		    	$uploaded_on = date("Y-m-d H:i:s");
		    	$uploaded_by = $this->flexi_auth->get_user_identity();
		    	$query = "insert into file_directory_link (directory_link, status, num_pages,uploaded_by,uploaded_on) values('$directory_link' , 'Activated', $num_pages, '$uploaded_by','$uploaded_on')";
		    	$this->db->query($query);
		    	
		    }
		    else
		    	$this->error=true;
		}

		return $this->error;
	}




}