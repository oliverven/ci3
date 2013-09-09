<?php if (! defined('BASEPATH')) exit('No direct script access allowed');



class Files_model extends CI_Model{


	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	public function getCount(){
		return $this->db->count_all('file_directory_link');
	}

	public function fetchFiles($limit, $start){
		$this->db->limit($limit,$start);

		$query = $this->db->get('file_directory_link');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}

	function getFiles()
	{
		
		// Get url for any search query or pagination position.
		$uri = $this->uri->uri_to_assoc(3);
		// Set pagination limit, get current position and get total files.
		$limit = 15;
		$offset = (isset($uri['page'])) ? $uri['page'] : FALSE;		
		
		// Set SQL WHERE condition depending on whether a user search was submitted.
		if (array_key_exists('search', $uri))
		{
			// Set pagination url to include search query.
			$pagination_url = 'auth_admin/manage_files/search/'.$uri['search'].'/';
			$config['uri_segment'] = 6; // Changing to 6 will select the 6th segment, example 'controller/function/search/query/page/10'.

			// Convert uri '-' back to ' ' spacing.
			$search_query = "select * from file_directory_link where directory_link like '%".$uri['search']."%' or uploaded_by like '%".$uri['search']."%'";		
			//total Files
			$total_files = $this->db->query($search_query)->num_rows();
			$data['files'] = $this->db->query($search_query);
		}
		else
		{
			// Set some defaults.
			$pagination_url = 'auth_admin/manage_files/';
			$search_query = FALSE;
			$config['uri_segment'] = 4; // Changing to 4 will select the 4th segment, example 'controller/function/page/10'.
			
			$total_files = $this->db->query("select * from file_directory_link")->num_rows();

			$data['files'] = $this->db->query("select * from file_directory_link");
		}
		
		// Create user record pagination.
		$this->load->library('pagination');	
		$config['base_url'] = base_url().$pagination_url.'page/';
		$config['total_rows'] = $total_files;
		$config['per_page'] = $limit; 
		$this->pagination->initialize($config); 
		
		// Make search query and pagination data available to view.
		$data['search_query'] = $search_query; // Populates search input field in view.
		$data['pagination']['links'] = $this->pagination->create_links();
		$data['pagination']['total_files'] = $total_files;
		return $data;
	}


	public function getAllFiles(){
		$res = $this->db->query("select * from file_directory_link");

		return $res;
	}

	public function change_status($id, $action){
		$status = '';
		if ($action == 'activate')
			$status = "Activated";
		else
			$status = "Deactivated";

		$data = array('status' => $status);
		$where = "directory_link_id = $id";
		$query = $this->db->update_string('file_directory_link', $data, $where);
		$res = $this->db->query($query);
		return $res;
	}

	public function delete_files($files = false){
		$error = true;
		if ($files){
			foreach ($files as $file => $val){
				$target = $this->getFileDirectoryLink($file);
				$path = "uploads/" . $target;
				if (file_exists($path)){
					unlink($path);
					$query = "delete from file_directory_link where directory_link_id= $file";
					$this->db->query($query);

					$q2 = "delete from file_ocr_text where directory_link_id = $file";
					$this->db->query($q2);

					$q3 = "delete from materials where directory_link_id = $file";
					$this->db->query($q3);
				}
				else
					$error = false;
			}
		}
		else
			$error = false;
		return $error;

	}

	public function getName($id){
		$query = "select directory_link from file_directory_link where directory_link_id = $id";
		$res = $this->db->query($query);
		$rows = $res->num_rows();
		if ($rows>0)
			return $res->row()->directory_link;
		else
			return false;
	}

	public function getFileDirectoryLink($val){

		$query = "select directory_link from file_directory_link where ";
		if (is_integer($val) )
			$query.="directory_link_id =$val";
		else
			$query.="directory_link = '$val'";
		$res = $this->db->query($query);
		$rows = $res->num_rows();
		if ($rows > 0)
			return $res->row()->directory_link;
		else
			return false;

	}

	public function getFileOCR($id){
		$query = "select ocr_text,file_ocr_text_id from file_ocr_text where directory_link_id = $id";
		$res = $this->db->query($query);
		$rows = $res->num_rows();
		if ($rows>0)
			return $res->result();
		else
			return false;
	}
}