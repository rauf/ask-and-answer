<?php

class Forms extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}

	public function getForms() {

		$data = array(
				'registerForm' => $this->load->view('auth/register', null, true),
				'loginForm' => $this->load->view('auth/login', null, true)
			);

		return $this->output
                ->set_header("HTTP/1.0 200 OK")
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
	}
}