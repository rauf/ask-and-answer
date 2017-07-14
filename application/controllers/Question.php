<?php

class Question extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('question/question_model');
		$this->load->helper('url_helper');
		$this->load->helper('cookie');
		$this->load->model('user/user_model');
		$this->load->model('answer/answer_model');
		$this->load->model('auth/session_model');
	}

	public function index() {
		$data['questions'] = $this->question_model->get_question_by_page(0, 10);
		$data['title'] = 'All Questions';
		$data['view'] = 'questions/index';

		$ownerIdArray = array();
		$questionIdArray = array();
		foreach ($data['questions'] as $key => $value) {
			$ownerIdArray[] = $value['ownerId'];
			$questionIdArray[] = $value['qid'];
		}
		$ownerIdArray = array_unique($ownerIdArray);
		$data['owner_name'] = $this->user_model->get_user_where_in($ownerIdArray, 'uid,first_name,last_name');

		$data['answer_counts'] = $this->answer_model->get_number_of_answers($questionIdArray);
		$this->load->view('layout/main_layout', $data);
	}

	public function detail($id) {

		$this->question_model->increment_views($id);

		$data['question'] = $this->question_model->get_question($id);

		if (is_null($data['question'])) {
			show_404();
		}

		$data['title'] = 'Question Detail Page';
		$data['view'] = 'questions/detail';
		$data['answers'] = $this->answer_model->get_answers($id);
		$data['question_owner_name'] = $this->user_model->get_user($data['question']['ownerId'])['first_name'];
		$data['qid'] = $id;

		$ownerIdArray = array();
		foreach ($data['answers'] as $key => $value) {
			$ownerIdArray[] = $value['ownerId'];
		}
		$ownerIdArray = array_unique($ownerIdArray);
		$data['owner_name'] = $this->user_model->get_user_where_in($ownerIdArray, 'uid,first_name,last_name');
		$this->load->view('layout/main_layout', $data);
	}

	public function get_by_page() {
		$page = $this->input->post('page');
		$length = $this->input->post('length');

		if (strlen($page) == 0 || strlen($length) == 0) {
			return;
		}

		$data['questions'] = $this->question_model->get_question_by_page($page, $length);

		$ownerIdArray = array();
		$questionIdArray = array();
		foreach ($data['questions'] as $key => $value) {
			$ownerIdArray[] = $value['ownerId'];
			$questionIdArray[] = $value['qid'];
		}
		$ownerIdArray = array_unique($ownerIdArray);
		$data['owner_name'] = $this->user_model->get_user_where_in($ownerIdArray, 'uid,first_name,last_name');
		$data['answer_counts'] = $this->answer_model->get_number_of_answers($questionIdArray);
		
		$res['questions'] = $this->load->view('questions/page', $data, true);
		$res['status'] = 'success';

		if (count($data['questions']) == 0) {
			$res['status'] = 'failure';
		}

		return $this->output
                ->set_header("HTTP/1.0 200 OK")
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
	}

	public function add() {
		if (! $this->session_model->valid()) {
			return;
		}
		$this->question_model->add_question();
	}

}