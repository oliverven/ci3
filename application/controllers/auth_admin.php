<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_admin extends CI_Controller {
 
    function __construct() 
    {
        parent::__construct();
 		
		// Load required CI libraries and helpers.
		$this->load->database();
		$this->load->library('session');
 		$this->load->helper('url');
 		$this->load->helper('form');
 		$this->load->helper('security');

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;

		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');	

		// Check user is logged in as an admin.
		// For security, admin users should always sign in via Password rather than 'Remember me'.
		if (! $this->flexi_auth->is_logged_in_via_password()) 
		{
			// Set a custom error message.
			$this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('auth');
		}

		// Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
		$this->load->vars('base_url', 'http://'.$_SERVER['SERVER_NAME'].'/ci3/');
		$this->load->vars('includes_dir', 'http://'.$_SERVER['SERVER_NAME'].'/ci3/includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
		
		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
	}


	function index()
    {
		$this->dashboard();
	}
 
 	/**
 	 * dashboard (Admin)
 	 */
    function dashboard()
    {
    	if ( $this->flexi_auth->is_privileged('Admin Dashboard')){
			$this->data['message'] = $this->session->flashdata('message');

			//
			$q ="select * from file_directory_link order by num_views desc limit 5";
			$res = $this->db->query($q)->result();
			
			$this->data['top5'] = $res;

			$total_files = $this->db->query("select * from file_directory_link")->num_rows();

			$this->data['total_files'] = $total_files;

			$this->load->view('demo/admin_examples/dashboard_view', $this->data);
		}
		else{
			// Set a custom error message.
			$this->flexi_auth->set_error_message('You do not have the privilege to access this page.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('welcome');
		}

	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// User Accounts
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	function register_account()
	{

		// Check user has privileges to view user accounts, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Insert Patron'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to view this page.</p>');
			redirect('auth_admin');
		}

		$response = false;
		// If 'Registration' form has been submitted, attempt to register their details as a new account.
		if ($this->input->post('register_user'))
		{			
			$this->load->model('demo_auth_model');
			$response = $this->demo_auth_model->register_account();
			if ($response)
				redirect('auth_admin/manage_user_accounts');
		}

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];


		$this->load->view('demo/public_examples/register_view', $this->data);
	}
    function manage_user_accounts()
    {
		$this->load->model('demo_auth_admin_model');

		// Check user has privileges to view user accounts, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Patrons'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to view this page.</p>');
			redirect('auth_admin');
		}

		// If 'Admin Search Patron' form has been submitted, this example will lookup the users email address and first and last name.
		if ($this->input->post('search_users') && $this->input->post('search_query')) 
		{
			if ($this->flexi_auth->is_privileged('Search Patron')){
				// Convert uri ' ' to '-' spacing to prevent '20%'.
				// Note: Native php functions like urlencode() could be used, but by default, CodeIgniter disallows '+' characters.
				$search_query = str_replace(' ','-',$this->input->post('search_query'));
			
				// Assign search to query string.
				redirect('auth_admin/manage_user_accounts/search/'.$search_query.'/page/');
			}
			else{
				$this->data['message'] = '<p class="error_msg">You do not have privilege to perform this action.</p>';
			}
		}
		// If 'Manage User Accounts' form has been submitted and user has privileges to update user accounts, then update the account details.
		else if ($this->input->post('update_users') && $this->flexi_auth->is_privileged('Update Patrons')) 
		{
			$this->demo_auth_admin_model->update_user_accounts();
		}

		// Get user account data for all users. 
		// If a search has been performed, then filter the returned users.
		$this->demo_auth_admin_model->get_user_accounts();
		
		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/user_acccounts_view', $this->data);		
    }
	
 	/**
 	 * update_user_account
 	 * Update the account details of a specific user.
 	 */
	function update_user_account($user_id)
	{
		// Check user has privileges to update user accounts, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Patrons') || !$user_id)
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to update user accounts.</p>');
			redirect('auth_admin');		 
		}

		// If 'Update User Account' form has been submitted, update the users account details.
		if ($this->input->post('update_users_account')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_account($user_id);
		}
		
		// Get users current data.
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
	
		// Get user groups.
		$this->data['groups'] = $this->flexi_auth->get_groups_array();
		
		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/user_account_update_view', $this->data);
	}

	function change_password($identity)
	{
		// If 'Update Password' form has been submitted, validate and then update the users password.
		if ($this->input->post('change_password') && $this->flexi_auth->is_privileged('Change Password of all Patrons'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->change_password($identity);
		}
				
		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('demo/public_examples/password_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// User Groups
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    function manage_user_groups()
    {
		// Check user has privileges to view patron groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Patron Groups'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to view patron groups.</p>');
			redirect('auth_admin');		
		}

		// If 'Manage User Group' form has been submitted and user has privileges, delete patron groups.
		if ($this->input->post('delete_group') && $this->flexi_auth->is_privileged('Delete Patron Groups')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->manage_user_groups();
		}

		// Define the group data columns to use on the view page. 
		// Note: The columns defined using the 'db_column()' functions are native table columns to the auth library. 
		// Read more on 'db_column()' functions in the quick help section near the top of this controller. 
		$sql_select = array(
			$this->flexi_auth->db_column('user_group', 'id'),
			$this->flexi_auth->db_column('user_group', 'name'),
			$this->flexi_auth->db_column('user_group', 'description'),
			$this->flexi_auth->db_column('user_group', 'admin')
		);
		$this->data['user_groups'] = $this->flexi_auth->get_groups_array($sql_select);
				
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/user_groups_view', $this->data);		
    }

    function manage_group_privileges($ugrp_id = false){

    	if (!$ugrp_id)
 			redirect('auth_admin');
    	// Check user has privileges to view patron groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Group Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to view this page.</p>');
			redirect('auth_admin');		
		}

		// If 'Manage User Group' form has been submitted and user has privileges, delete patron groups.
		if ($this->input->post('submit')) 
		{
			$obj = $this->input->post('privileges');
			$list = array();
			$cur_list = array();
			$affected_rows = 0;
			
			//The list is NOT empty.
			if ($obj){
				//converting objects associative arrays into iterative arrays
				foreach( $obj as $index => $val){
					array_push($list,$index);
				} 

				if ($ugrp_id == false)
					redirect('auth_admin');
				$get = "select upriv_id from user_group_privileges where ugrp_id=$ugrp_id";
				$cur = $this->db->query($get)->result();
				//converting objects into iterative arrays
				foreach($cur as $val){
					array_push($cur_list, $val->upriv_id);
				}
				//Find out which privileges to delete
				$insert = array_diff($list, $cur_list);
				$delete = array_diff($cur_list, $list);
				//Inserting privileges
				foreach($insert as $val){
					$this->db->query("insert into user_group_privileges (ugrp_id,upriv_id) values ($ugrp_id, $val)");
				}
				//Deleting privileges
				foreach($delete as $val){
					$this->db->query("delete from user_group_privileges where ugrp_id=$ugrp_id and upriv_id=$val");
				}
				$affected_rows = $this->db->affected_rows();

			}
			//The list is empty, meaning you didn't give any privilege
			else{
				if (!$ugrp_id)
					redirect('auth_admin');
				$clear="delete from user_group_privileges where ugrp_id=$ugrp_id";
				$this->db->query($clear);
				$affected_rows = $this->db->affected_rows();
			}
			if ($affected_rows > 0)
				$this->data['message'] = '<p class="status_msg">Successfully updated group privileges.</p>';

		}
		$query = "select * from user_group_privileges where ugrp_id =". $ugrp_id;
		$this->data['current_priv'] = $this->db->query($query)->result();
		$query = "select * from user_privileges order by upriv_name";
		$this->data['privileges'] = $this->db->query($query)->result_array();
				
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('group_privileges_view', $this->data);
    }
	
 	/**
 	 * insert_user_group
 	 * Insert a new user group.
 	 */
	function insert_user_group()
	{
		// Check user has privileges to insert patron groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Insert Patron Groups'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to view this page.</p>');
			redirect('auth_admin/manage_user_groups');		
		}

		// If 'Add User Group' form has been submitted, insert the new user group.
		if ($this->input->post('insert_user_group')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->insert_user_group();
		}
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/user_group_insert_view', $this->data);
	}
	
 	/**
 	 * update_user_group
 	 * Update the details of a specific user group.
 	 */
	function update_user_group($group_id)
	{
		// Check user has privileges to update patron groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Patron Groups') | !$group_id)
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to perform this action.</p>');
			redirect('auth_admin/manage_user_groups');		
		}

		// If 'Update patron Group' form has been submitted, update the user group details.
		if ($this->input->post('update_user_group')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_group($group_id);
		}

		// Get user groups current data.
		$sql_where = array($this->flexi_auth->db_column('user_group', 'id') => $group_id);
		$this->data['group'] = $this->flexi_auth->get_groups_row_array(FALSE, $sql_where);
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/user_group_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Privileges
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
    function manage_privileges()
    {
		// Check user has privileges to view user privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin');		
		}
		
		// If 'Manage Privilege' form has been submitted and the user has privileges to delete privileges.
		if ($this->input->post('delete_privilege') && $this->flexi_auth->is_privileged('Delete Privileges')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->manage_privileges();
		}

		$query = "select * from user_privileges order by upriv_name";
		$this->data['privileges'] = $this->db->query($query)->result_array();

		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/privileges_view', $this->data);
	}

 	/**
 	 * insert_privilege
 	 * Insert a new user privilege.
 	 */
	function insert_privilege()
	{
		// Check user has privileges to insert patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Insert Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/manage_privileges');		
		}

		// If 'Add Privilege' form has been submitted, insert the new privilege.
		if ($this->input->post('insert_privilege')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->insert_privilege();
		}
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/privilege_insert_view', $this->data);
	}
	
 	/**
 	 * update_privilege
 	 * Update the details of a specific user privilege.
 	 */
	function update_privilege($privilege_id)
	{
		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Privileges') | !$privilege_id)
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/manage_privileges');		
		}

		// If 'Update Privilege' form has been submitted, update the privilege details.
		if ($this->input->post('update_privilege')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_privilege($privilege_id);
		}
		
		// Get privileges current data.
		$sql_where = array($this->flexi_auth->db_column('user_privileges', 'id') => $privilege_id);
		$this->data['privilege'] = $this->flexi_auth->get_privileges_row_array(FALSE, $sql_where);
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/privilege_update_view', $this->data);
	}
	
 	/**
 	 * update_user_privileges
 	 * Update the access privileges of a specific user.
 	 */
    function update_user_privileges($user_id)
    {
		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Patron Privileges') || !$user_id)
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to perform this action.</p>');
			redirect('auth_admin/manage_user_accounts');		
		}

		// If 'Update User Privilege' form has been submitted, update the user privileges.
		if ($this->input->post('update_user_privilege')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_privileges($user_id);
		}

		// Get users profile data.
		$sql_select = array('upro_uacc_fk', 'upro_first_name', 'upro_last_name');
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array($sql_select, $sql_where);
		// Get all privilege data. 
		$sql_select = array(
			$this->flexi_auth->db_column('user_privileges', 'id'),
			$this->flexi_auth->db_column('user_privileges', 'name'),
			$this->flexi_auth->db_column('user_privileges', 'description')
		);
		$ugrp_id = $this->db->query("select uacc_group_fk from user_accounts where uacc_id=$user_id")->result();
		$ugrp_id = $ugrp_id[0]->uacc_group_fk;
		//THE LIST OF Possible privileges to be assigned
		$priv = $this->db->query("select upriv_id from user_group_privileges where ugrp_id=$ugrp_id")->result_array();
		//converting into simple array
		$list = array();
		if ($priv){
			foreach($priv as $val){
				array_push($list,$val['upriv_id']);
			}
		}
		//Get the information of the privileges
		$info = $this->db->query("select * from user_privileges order by upriv_name")->result_array();

		$final_list = array();
		foreach($info as $val){
			if (in_array($val['upriv_id'],$list) )
				array_push($final_list,$val);
		}
		$this->data['privileges'] = $final_list;
		
		// Get users current privilege data.
		$sql_select = array($this->flexi_auth->db_column('user_privilege_users', 'privilege_id'));
		$sql_where = array($this->flexi_auth->db_column('user_privilege_users', 'user_id') => $user_id);
		$user_privileges = $this->flexi_auth->get_user_privileges_array($sql_select, $sql_where);
	
		// For the purposes of the example demo view, create an array of ids for all the users assigned privileges.
		// The array can then be used within the view to check whether the user has a specific privilege, this data allows us to then format form input values accordingly. 
		$this->data['user_privileges'] = array();
		foreach($user_privileges as $privilege)
		{
			$this->data['user_privileges'][] = $privilege[$this->flexi_auth->db_column('user_privilege_users', 'privilege_id')];
		}
	
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/admin_examples/user_privileges_update_view', $this->data);		
    }



	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// FILE MANAGEMENT
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	public function upload(){
		

		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Upload Page'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to perform this action.</p>');
			redirect('auth_admin/');		
		}
		$this->load->model('files_model');
		$this->load->model('upload_model');
		if ($this->input->post('upload')){
			if (!$this->upload_model->do_upload())
				$this->load->view('upload_form' , array('message' => '<p class="status_msg">Successfully uploaded file.</p>'));
			else{
				if ($this->upload_model->upload->display_errors() == "")
					$this->load->view('upload_form' , array('message' => '<p class="error_msg">An error has occurred</p>'));
				else
					$this->load->view('upload_form' , array('message' => '<p class="status_msg">Successfully uploaded file.</p>'));
			}
		}
		else
			$this->load->view('upload_form' , array('data' =>' '));
	}

	public function manage_files($message = ""){

		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Files Management Page'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}

		$this->load->model('files_model');
		$data = array();
		$data['message'] = $message;
		// If 'Search Files' form has been submitted
		if ($this->input->post('search_files') && $this->input->post('search_query')) 
		{
				$search_query = str_replace(' ','-',$this->input->post('search_query'));
			
				// Assign search to query string.
				redirect('auth_admin/manage_files/search/'.$search_query.'/page/');
		}
		else if ($this->input->post('delete_files') && $this->flexi_auth->is_privileged('Delete Files')){
			if (!$this->files_model->delete_files($this->input->post('files')))
				$data['message'] = '<p class="error_msg">An error has occurred.</p>';
			else
				$data['message'] = '<p class="status_msg">Successfully Deleted.</p>';
		}
		$files = $this->files_model->getFiles();
		$files['page_title'] = "Manage Files";
		$files['num_rows'] = $this->files_model->getAllFiles()->num_rows();

		$this->load->view('manage_files' , $files);
	}

	public function save_changes(){
		$id =  $this->input->post('file_ocr_text_id');
		$text = $this->input->post('ocr_text');
		$q = "update file_ocr_text set ocr_text = ? where file_ocr_text_id = ?";
		$this->db->query($q,array($text,$id) );
		echo "<script>window.close();</script>";
	}

	public function change_file_status(){
		$this->load->model('files_model');
		if ($this->flexi_auth->is_privileged('Update File Status')&&!$this->files_model->change_status($this->input->get('id') , $this->input->get('to')))
			$message= '<p class="error_msg">An error has occurred.</p>';
		else
			$message='<p class="status_msg">Successfully Updated Record.</p>';
		$this->manage_files($message);
	}

	public function view_ocr_pages($id){
		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View File OCR Text') | !$id)
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}
		$this->load->model('files_model');

		$data['ocr_text'] = $this->files_model->getFileOCR($id);
		$data['page_title'] = $this->files_model->getName($id);

		$this->load->view('view_ocr_popup',$data);
	}

	public function perform_ocr(){

		$id = $this->uri->segment(3);
		$filename = $this->uri->segment(4);

		$this->load->library('tesseract_ocr');
		$this->dir = "C:/xampp/htdocs/ci3/";

		$ocr_text = array();

		$numPages = $this->tesseract_ocr->getNumOfPages($filename);

		//$numPages = 2;

		$len = strlen($filename);
		$len = $len - 4;
		//Extracting the PDF Pages into .png files
		for ($i = 0 ; $i < $numPages ; $i++){
			$this->tesseract_ocr->convertToTiffImage(substr($filename,0,$len).".pdf"."[$i]");
		}
		
		//Extracting text from the .tiff files
		for ($i = 0 ; $i < $numPages ; $i++){
			array_push($ocr_text,$this->tesseract_ocr->recognize($filename."[$i]".".png"));
		}

		//Insert into database
		for ($i=0;$i<$numPages;$i++){
			$query = "insert into file_ocr_text (directory_link_id, page_num, ocr_text) values (?, ?, ?)";
			if ($this->db->query($query, array($id, $i, $ocr_text[$i]))){
				$q = "update file_directory_link set processed=true where directory_link_id = $id";
				$this->db->query($q);
			}

		}


		$this->session->set_flashdata('message', '<p class="status_msg">OCR Process was successful.</p>');
		redirect('auth_admin/manage_files');		

	}


	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CATALOGING
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	public function manage_material_type(){

		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Material Types Page'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}


		$this->load->model('material_type_model');
		$data = array();
		if ($this->input->post('delete_materials') && $this->flexi_auth->is_privileged('Delete Material Type')){
			if (!$this->material_type_model->delete_materials($this->input->post('files'))){
				$data['message'] = '<p class="error_msg">An error has occurred.</p>';
			}
			else
				$data['message'] = '<p class="status_msg">Successfully Deleted Record.</p>';
		}
		$files = $this->material_type_model->getAllMaterials();
		$data['files'] = $files;
		$data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->load->view('manage_material_type_view' , $data);
	}

	public function add_material_type(){

		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Insert Material Type'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}
		

		$message = "";
		if ($this->input->post('add_material') && $this->flexi_auth->is_privileged('Insert Material Type')){
			$this->load->model('material_type_model');
			$printable= ($this->input->post('printable') == 'on' ? 1 : 0);
			if (!$this->material_type_model->add_material($this->input->post("material_type"), $this->input->post("description"), $printable)){
				$message =  '<p class="error_msg">An error has occurred.</p>';
			}
			else{
				$this->session->set_flashdata('message', '<p class="status_msg">Successfully Added New Record.</p>');
				redirect('auth_admin/manage_material_type');
			}
		}
		$data['message'] = $message;
		$this->load->view('add_material_type_view',$data);
	}

	public function manage_material_marc(){

		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Material Marc Tags') | !$this->input->get('id'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}

		$this->load->model('material_type_model');	
		if ($this->input->post('submit') && $this->input->post('material_tags')){
			$files = $this->input->post('material_tags');
			if (!$this->material_type_model->deleteMaterialMarc($files,$this->input->get('id')))
				$data['message'] = '<p class="status_msg">Successfully Deleted Record.</p>';
			else
				$data['message'] ='<p class="error_msg">An error has occurred.</p>';
		}
		$data['marc_tags'] = $this->material_type_model->manage_marc($this->input->get('id'));
		$this->load->view('manage_material_marc_view',$data);
	}

	public function edit_material_marc_tag($id){

		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Material Marc Tags') | !$id)
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}
	}

	public function edit_material(){
		$data['message'] = '';
		$this->load->model('material_type_model');

		if (! $this->flexi_auth->is_privileged('Update Material Type') || !$this->input->get('id'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}
		
		if ($this->flexi_auth->is_privileged('Update Material Type')&&$this->input->post('edit_material')){
			$this->load->model('material_type_model');
			$printable = ($this->input->post('printable') == 'on'? 1 : 0);
			if ($this->material_type_model->edit_material(
						$this->input->post('material_type_id'),
						$this->input->post('material_type'),
						$this->input->post('description'),
						$printable))
				$data['message'] = '<p class="status_msg">Successfully Edited Record.</p>';
			else
				$data['message'] = '<p class="error_msg">An error has occurred.</p>';
		}
		$data['file'] = $this->material_type_model->get_material($this->input->get('id'));
		$this->load->view('edit_material_view',$data);
	}

	public function add_material_marc(){

		if (! $this->flexi_auth->is_privileged('Update Material Marc Tags') || !$this->input->get('id'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}
		$this->load->model("marc_tag_model");
		$data['marc_block'] = $this->marc_tag_model->getAllMarcBlock();
		$data['marc_tag'] = $this->marc_tag_model->getAllMarcTag();
		$data['marc_subfield'] = $this->marc_tag_model->getAllMarcTagSubfield();
		if ($this->input->post("submit")){
			if ($this->marc_tag_model->add_material_marc(
											$this->input->post('mat_id'),
											$this->input->post('s_marc_tag_id'),
											$this->input->post('s_marc_subfield'),
											$this->input->post('s_description')))
				$data['message'] = '<p class="status_msg">Successfully inserted data.</p>';
			else
				$data['message'] = '<p class="error_msg">An error has occured.</p>';
		}
		$this->load->view('add_material_marc', $data);
	}

	public function add_material_content($id){
		$this->load->model("marc_tag_model");
		$data['marc_block'] = $this->marc_tag_model->getAllMarcBlock();
		$data['marc_tag'] = $this->marc_tag_model->getAllMarcTag();
		$data['marc_subfield'] = $this->marc_tag_model->getAllMarcTagSubfield();
		if ($id) $data['mat_type_id'] = $id;
		if ($this->input->post("submit")){
			if ($this->marc_tag_model->add_material_marc(
											$this->input->post('mat_id'),
											$this->input->post('s_marc_tag_id'),
											$this->input->post('s_marc_subfield'),
											$this->input->post('s_description')))
				$data['message'] = "Successfully inserted data.";
			else
				$data['message'] = "An error has occured.";
		}
		$this->load->view('add_material_details', $data);
	}

	public function manage_bibliography(){
		if (! $this->flexi_auth->is_privileged('View Bibliography'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}


		$this->load->view('manage_bibliography_view');
	}

	public function manage_materials(){
		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Materials'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}
		$this->load->model('materials_model');
		if ($this->flexi_auth->is_privileged('Delete Materials')){
			if ($this->input->post('submit') && $this->input->post('files')){
				$files = $this->input->post('files');
				if ($this->materials_model->deleteMaterials($files))
					$data['message'] = '<p class="status_msg">Successfully Deleted Record.</p>';
				else
					$data['message'] ='<p class="error_msg">An error has occurred.</p>';
			}
		}
		else{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}
		$data['materials'] = $this->materials_model->getAllMaterials();

		$this->load->view('manage_materials',$data);
	}

	public function add_material(){
		// Check user has privileges to update patron privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Add Material'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have the privilege to access this page.</p>');
			redirect('auth_admin/');		
		}

		$this->load->model('materials_model');
		if ($this->input->post('submit')){
			$file = $this->input->post('directory_link_id');
			$mat_type = $this->input->post('material_type_id');
			$pages = $this->input->post('pages_from') . "-". $this->input->post('pages_to');
			$desc = $this->input->post('mat_desc');
			if ($this->materials_model->insertMaterial($file,$mat_type,$pages,$desc))
				$data['message'] = '<p class="status_msg">Successfully inserted record.</p>';
			else
				$data['message'] = '<p class="error_msg">An error has occured.</p>';
		}

		$data['files'] = $this->materials_model->getFiles();
		$data['material_types'] = $this->materials_model->getMaterialTypes();
		$this->load->view('add_material',$data);
	}


	public function assign_marc_tags(){

		$material_id = $this->uri->segment(3);
		$material_type_id = $this->uri->segment(4);
		$data=false;
		if (!$material_id){
			redirect('auth_admin');
		}

		if ($this->input->post('submit')){
			$delete = $this->input->post('files');
			if ($delete){
				foreach($delete as $del => $w){
					$q="delete from material_tag_values where material_tag_values_id = $del";
					$this->db->query($q);
				}
				$data['message'] = '<p class="status_msg">Successfully deleted record.</p>';
			}
		}
		//$q = "select 
		//		mat_tag.material_tag_values_id, marc.marc_tag_id, marc.description, mat_tag.tag_value from material_tag_values as mat_tag
		//		inner join marc_tag as marc
		//
		//		on marc.marc_tag_id = mat_tag.marc_tag_id";
		$q= "select * from material_tag_values where material_id = $material_id";

		$data['tags'] = $this->db->query($q)->result();
		
		$this->load->view('assign_tags',$data);
	}

	public function addTags(){
		$material_id = $this->uri->segment(3);
		$material_type_id = $this->uri->segment(4);
		if (!$material_id){
			redirect('auth_admin');
		}

		if ($this->input->post('submit')){
			$directory_link_id = $this->input->post('directory_link_id');
			$insert = $this->input->post('tags');
			$flag=0;
			foreach($insert as $index => $val){
				if ($val!= ""){
					$q = "insert into material_tag_values (material_id, marc_tag_id, tag_value, directory_link_id) values($material_id, $index, '$val', $directory_link_id)";
					if (!$this->db->query($q))
						$flag=1;
				}
			}
			if ($flag==1){
				$data['message'] = '<p class="error_msg">An error has occurred.</p>';
			}
			else
				$data['message'] = '<p class="status_msg">Successfully inserted record.</p>';
			//redirect('auth_admin/assign_marc_tags/1/29');
			
		}

		$q ='select mat.directory_link_id, mat.material_id, m_tag.description, m_tag.marc_tag_id,mat.material_type_id
				from marc_tag as m_tag,
					 material_marc_tags as mat_marc,
					 materials as mat
				where mat_marc.marc_tag_id = m_tag.marc_tag_id and
					  mat_marc.material_type_id = mat.material_type_id';

		$data['tags'] = $this->db->query($q)->result();


		$this->load->view('addtags',$data);

	}


}
