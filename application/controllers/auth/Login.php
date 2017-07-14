<?php

class Login extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('auth/login_model');
		$this->load->model('user/user_model');
	}

	public function process() {
			
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = false;
		
		if (strlen($email) != 0 && strlen($password) != 0) {
			$result = $this->login_model->validate($email, $password);
		}
		$res['status'] = 'failure';
		$res['message'] = 'Email/Password does not match';
		$res['uid'] = '0';

		if ($result) {
			$res['status'] = 'success';
			$res['message'] = "Login successfull";
			$user = $this->user_model->get_user_by_email($email);
			$res['uid'] = $user['uid'];
		}

		return $this->output
                ->set_header("HTTP/1.0 200 OK")
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
	}
}