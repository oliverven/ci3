<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct(){
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
	public function index()
	{
		$data=null;
		$this->load->helper('url');	
		$this->load->view('welcome_message',$data);
	}

	public function view_ocr_pages($id){

		$this->load->model('files_model');

		$data['ocr_text'] = $this->files_model->getFileOCR($id);
		$data['page_title'] = $this->files_model->getName($id);

		$this->load->view('view_ocr_public',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */