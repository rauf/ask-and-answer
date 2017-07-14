<?php

class Question_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	public function get_question($qid = false) {
		if ($qid === false) {
			$query = $this->db->order_by('posted_time', 'desc')->get('question');
			return $query->result_array();
		}
		$query = $this->db->get_where('question', array('qid' => $qid));
		return $query->row_array();
	}

	public function add_question() {
		$title = $this->input->post('title');
		$ownerId = $this->input->post('ownerId');
		$description = $this->input->post('description');

		$res['status'] = 'failure';
		$res['qid'] = '0';

		if (strlen($title) != 0 && strlen($ownerId)) {
			$queryStr = "INSERT INTO question (ownerId, title, description, posted_time, views) VALUES (?, ?, ?, NOW(), 0)";
			$this->db->query($queryStr, array($ownerId, $title, $description));
			$res['qid'] = $this->db->insert_id();
		}
		return $this->output
                ->set_header("HTTP/1.0 200 OK")
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
	}

	public function increment_views($qid) {
		$this->db->set('views', 'views+1', FALSE)->where('qid', $qid)->update('question');
	}

	public function get_question_by_page($page, $length) {
		$query = $this->db->order_by('posted_time', 'desc')->limit($length, $page * $length)->get('question');
		return $query->result_array();
	}

}