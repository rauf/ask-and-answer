<?php

class SessionController extends CI_Controller{
	
	public function __construct() {
		parent::__construct();
		$this->load->model('auth/session_model');
		$this->load->library('session');
	}

	public function logout() {
		$this->session_model->endSession();
	}
}