<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller{

	function __construct() 
    {
        parent::__construct();
 		
		// Load required CI libraries and helpers.
		$this->load->database();
		$this->load->library('session');
 		$this->load->helper('url');
 		$this->load->helper('form');
 		$this->auth = new stdClass;

 		$this->load->vars('base_url', 'http://'.$_SERVER['SERVER_NAME'].'/ci3/');
		$this->load->vars('includes_dir', 'http://'.$_SERVER['SERVER_NAME'].'/ci3/includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));

  		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');	
	}


	function index()
    {
    	$data = null;
    	if ($this->input->get('keyword')){
	    	$keyword = $this->input->get('keyword');
	    	$author = $this->input->get('author');
	    	$title = $this->input->get('title');
	    	$subject = $this->input->get('subject');
	    	$data['keyword'] = $keyword;

	    	//construct the query
	    	
	    	// ADVANCED SEARCHING FROM MARC TAGS 100, 245, 650
	    	if ($author == 'on' || $title == 'on' || $subject == 'on'){
	    		$query = "select directory_link_id from material_tag_values where (";
		    	if ($author){
		    		$query.= "marc_tag_id = 100 or ";
		    	}
		    	if ($title){
		    		$query.= "marc_tag_id = 245 or ";
		    	}
		    	if ($subject){
		    		$query.= "marc_tag_id = 650 or ";
				}
				$query = substr($query, 0, strlen($query)-4);
				$query.= ") and tag_value like '%".$keyword."%'";
				$data['search_using'] = 'marc';
			}
			// KEYWORD SEARCHING FROM OCR
			else{
				$data['search_using'] = 'ocr';
				$query = "select * from file_ocr_text where ocr_text like '%". $keyword."%'";
			}
			$res = $this->db->query($query)->result();
			$final_list = array();
			//Filtering the resulsts --should not return more than 1 ID of a File
			foreach($res as $val){
				$id = $val->directory_link_id;
				if (!$this->checkIfInArray($id, $final_list)){
					$dir_link = $this->getDirLink($id);
					array_push($final_list, array("$id" => "$dir_link"));
				}	
			}

			$data['files'] = $final_list;
		}

		$this->load->view('welcome_message', $data);
	}

	function checkIfInArray($id,$arr){
		$flag = false;
		for ($i = 0; $i<count($arr); $i++){
			foreach($arr[$i] as $temp_id =>$dir_link){
				if ($temp_id == $id)
					$flag = true;
			}
		}
		return $flag;
	}

	function getDirLink($id){
		return $this->db->query("select directory_link from file_directory_link where directory_link_id = $id")->row()->directory_link;
	}



	function summarize($haystack,$needle,$wordLimit = 10) {

    // first get summary of text around key word (needle)
    $preg_safe = str_replace(" ", "\s", preg_quote($needle));
    $pattern = "/(\w*\S\s+){0,$wordLimit}\S*\b($preg_safe)\b\S*(\s\S+){0,$wordLimit}/ix";
    if (preg_match_all($pattern, $haystack, $matches)) {
        $summary = str_replace(strtolower($needle), "<strong>$needle</strong>", $matches[0][0]) . '...';
    } else {
        $summary = false;
    }

    return $summary;
	}

 
}