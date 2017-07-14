<?php

class Register_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('user/user_model');
    	$this->load->helper('form');
    	$this->load->library('form_validation');
	}
	
	public function getValidationMessage() {
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] = $this->input->post('last_name');
		$data['email'] = $this->input->post('email');
		$data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

		
		$res['status'] = 'failure';
		$res['message'] = 'validation error';
		$res['uid'] = '0';

		if (strlen($data['first_name']) == 0 || strlen($data['email']) == 0 
				|| strlen($data['password']) == 0) {
			$res['message'] = 'Fields are empty';
		}

		else if (strlen($data['password']) < 6) {
			$res['message'] = 'Password less than 6 characters';
		} 
		
		else if (! filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$res['message'] = 'Invalid email address';
		}

		else if (! $this->user_model->add_user_to_db($data)) {
			$res['message'] = 'User with this email address already present';
		} 
		else {
			$res['status'] = 'success';
			$res['message'] = 'User added to database';
		}

		$user = $this->user_model->get_user_by_email($data['email']);
		$res['uid'] = $user['uid'];
		return $res;
	}
}