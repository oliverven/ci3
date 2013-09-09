<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pdf_viewer extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
 		$this->load->helper('url');
 		$this->load->helper('form');
 		$this->auth = new stdClass;
 		$this->load->library('flexi_auth');	

		$this->load->vars('base_url', 'http://'.$_SERVER['SERVER_NAME'].'/ci3/');
		$this->load->vars('includes_dir', 'http://'.$_SERVER['SERVER_NAME'].'/ci3/includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
		$this->data = null;
	}

	public function index(){
		$this->load->helper('url');
	}
	
	public function v(){
		//Accepts directory_link
		$data['file'] = $this->input->get('file');
		$data['keyword'] = $this->input->get('keyword');

		//Retrieve last value
		$q = "select num_views from file_directory_link where directory_link ='".$data['file']."'";

		$last_view = $this->db->query($q)->row()->num_views;

		$new_view = $last_view + 1;

		//Update num_view
		$q = "update file_directory_link set num_views = $new_view where directory_link ='".$data['file']."'";
		$this->db->query($q);
		$this->load->view('pdf',$data);
		
	}

	public function file(){
		//Accepts directory_link_id;
		if ($this->input->get('id')){
			$query = "select * from file_directory_link where directory_link_id = ".$this->input->get('id');
			$res = $this->db->query($query)->row();
			$data['page'] = $this->input->get('page');
			$data['file'] = $res->directory_link;

			$this->load->view('pdf', $data);
		}
		else
			redirect('welcome');
	}

}

