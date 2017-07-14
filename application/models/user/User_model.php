<?php

class User_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function get_user($uid = false) {
		if ($uid === false) {
			$query = $this->db->get('user');
			return $query->result_array();
		}
		$query = $this->db->get_where('user', array('uid' => $uid));
		return $query->row_array();
	}

	public function get_user_by_email($email) {
		$query = $this->db->get_where('user', array('email' => $email));
		return $query->row_array();
	}

	public function get_user_where_in($arr) {

		if(!is_array($arr) || count($arr) == 0)
			return;

		$query = $this->db->select('uid,first_name,last_name')->where_in('uid', $arr)->get('user');
		$rs = $query->result_array();
		$result = array();
		foreach ($rs as $key => $value) {
			$result[$value['uid']] = array('first_name' => $value['first_name'],'last_name' => $value['last_name']);
		}
		return $result;
	}

	public function add_user_to_db($user) {
		if (!is_array($user) || count($user) == 0) 
			return false;

		$query = $this->db->get_where('user', array('email' => $user['email']));
		$count = $query->num_rows();

		if ($count === 0) {
			$this->db->insert('user', $user);
			return true;
		}
		return false;
	}

}