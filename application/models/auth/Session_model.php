<?php

class Session_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function valid() {
		$email = $this->session->userdata('email');
		$password = $this->session->userdata('password');

		if (strlen($email) == 0 || strlen($password) == 0) {
			return false;
		}

		$queryStr = "SELECT * FROM user WHERE email = ? AND password LIKE '". $this->db->escape_like_str($password)."%'";

		$query = $this->db->query($queryStr, array($email));
		return $query->num_rows() == 1; 
	}

	public function endSession() {
		$this->session->unset_userdata('first_name');
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('password');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('validated'); 
		$this->session->sess_destroy();
	}
}