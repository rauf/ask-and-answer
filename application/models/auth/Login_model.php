<?php

class Login_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function validate($email, $password) {
		
		$this->db->where('email', $email);
		$query = $this->db->get('user');
		
		if($query->num_rows() == 1) {

			$row = $query->row();
			
			if (! password_verify($password, $row->password)) return false;
			$data = array(
					'uid' => $row->uid,
					'password' => substr($row->password, 0, 30),
					'email' => $row->email,
					'first_name' => $row->first_name,
					'validated' => true
					);
			$this->session->set_userdata($data);
			return true;
		}
		return false;
	}
}