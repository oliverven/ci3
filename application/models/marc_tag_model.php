<?php if (!defined('BASEPATH')) exit("No direct script access allowed.");


class Marc_tag_model extends CI_Model{


	public function __construct(){
		parent::__construct();	
		$this->load->database();
	}

	public function getAllMarcBlock(){
		$query = "select * from marc_block";
		return $this->db->query($query)->result_array();
	}

	public function getAllMarcTag(){
		$query = "select * from marc_tag";
		return $this->db->query($query)->result_array();
	}

	public function getAllMarcTagSubfield(){
		$query = "select * from marc_subfield";
		return $this->db->query($query)->result_array();
	}

	public function add_material_marc($mat_id, $marc_tag_id, $subfield, $subfield_desc){
		$query = "insert into material_marc_tags (material_type_id, marc_tag_id, subfield, description) values 
			($mat_id,$marc_tag_id,'$subfield','$subfield_desc')";
		return $this->db->query($query);
	}


}