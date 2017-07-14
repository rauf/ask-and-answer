<?php

class Register extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('auth/register_model');
	}

	public function process() {
			
		$res = $this->register_model->getValidationMessage();

		return $this->output
                ->set_header("HTTP/1.0 200 OK")
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
	}
}