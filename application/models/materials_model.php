<?php if (!defined('BASEPATH')) exit("No direct script access allowed.");


class Materials_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function deleteMaterials($files){
		$flag=1;
		if ($files){
			foreach($files as $index => $val){
				$q = "delete from materials where material_id = $index";
				if (!$this->db->query($q))
					$flag=0;
			}
		}

		return $flag;
	}

	public function getAllMaterials(){
		$query ="select mat.material_id, mat.description, mat.pages, mat_type.material_type, dir.directory_link, dir.num_pages, mat_type.material_type_id from materials as mat,material_types as mat_type, file_directory_link as dir where mat.directory_link_id = dir.directory_link_id and mat.material_type_id = mat_type.material_type_id";
		$res = $this->db->query($query);
		if (!$res)
			return false;
		else
			return $res;
	}

	public function getFiles(){
		$query = "select * from file_directory_link";
		$res = $this->db->query($query);
		if (!$res)
			return false;
		else
			return $res;
	}

	public function getMaterialTypes(){
		$query = "select * from material_types";
		$res = $this->db->query($query);
		if (!$res)
			return false;
		else
			return $res;
	}

	public function insertMaterial($file,$mat_type,$pages,$desc){
		if ($file && $mat_type && $pages){
			$q = "insert into materials (directory_link_id, material_type_id, pages, description) values ($file,$mat_type, '$pages', '$desc')";
			return $this->db->query($q);
		}
	}




}