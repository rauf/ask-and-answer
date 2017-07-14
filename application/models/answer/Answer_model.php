<?php

class Answer_model extends CI_MODEL {
	
	function __construct()	{
		parent::__construct();
		$this->load->database();
	}

	function get_answers($id) {
		$query = $this->db->order_by('posted_time', 'desc')->get_where('answer', array('qid' => $id));
		return $query->result_array();
	}

	function addAnswerToDb() {
		$uid = $this->input->post('uid');
		$qid = $this->input->post('qid');
		$text = $this->input->post('text');

		if (strlen($uid) == 0 || strlen($qid) == 0 || strlen($text) == 0) {
			return;
		}

		$queryStr = "INSERT INTO answer (qid, ownerId, text, posted_time) VALUES (?, ?, ?, NOW())";
		$this->db->query($queryStr, array($qid, $uid, $text));
		
		return $this->output
                ->set_header("HTTP/1.0 200 OK")
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
	}

	public function get_number_of_answers($questioIdArray) {

		if(!is_array($questioIdArray) || count($questioIdArray) == 0)
			return;

		$query = $this->db->select('qid, count(*) AS count')->where_in('qid', $questioIdArray)
						->group_by('qid')
						->get('answer');

		$rs = $query->result_array();
		$result = array();
		
		foreach ($rs as $key => $value) {
			$result[$value['qid']] = $value['count'];
		}
		return $result;
	}
}