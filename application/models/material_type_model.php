<?php if (!defined('BASEPATH')) exit("No direct script access allowed.");


class Material_type_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getAllMaterials(){
		$res = $this->db->query("select * from material_types");
		return $res;
	}

	public function delete_materials($files=false){
		$error = true;
		if ($files){
			foreach ($files as $file => $val){
				$query = "delete from material_types where material_type_id = $file";
				$this->db->query($query);
				//delete also Material Marc Data
				$query = "delete from material_marc_tags where material_type_id = $file";
				$this->db->query($query);
				//delete also Materials
				$query  ="delete from materials where material_type_id = $file";
				$this->db->query($query);
			}
		}
		else
			$error = false;
		return $error;
	}

	public function add_material($name,$desc, $printable){
		$error = true;
		if ($name){
			$query = "insert into material_types (material_type, description,printable) values('$name', '$desc', $printable)";
			if (!$this->db->query($query))
				$error = false;
		}
		else
			$error = false;
		return $error;
	}

	public function edit_material($id, $name, $desc,$printable){
		$error = true;
		if ($name!=""){
			$query = "update material_types set material_type='$name', description='$desc', printable=$printable where material_type_id=$id";
			if (!$this->db->query($query))
				$error = false;
		}
		else
			$error = false;
		return $error;
	}

	public function get_material($id){
		$query = "select * from material_types where material_type_id = $id";
		return $this->db->query($query)->row();

	}

	public function manage_marc($id){
		$query = "select * from material_marc_tags where material_type_id = $id";
		return $this->db->query($query)->result();
	}

	public function deleteMaterialMarc($files,$id){
		$error = false;
		foreach($files as $file => $val){
			$query = "delete from material_marc_tags where material_type_id = $id and mm_tag_id = $file";
			if (!$this->db->query($query))
				$error = true;
		}
		return $error;
	}




}