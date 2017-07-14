<?php

class Answer extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('answer/answer_model');
	}

	public function add() {
		$this->answer_model->addAnswerToDb();
	}
}