<?php
	$this->load->view('templates/header', $data);
	$this->load->view($view, $data);
	$this->load->view('templates/footer', $data);
?>