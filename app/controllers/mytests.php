<?php

class Mytests extends CI_Controller {
	

	public function index()
	{

		$this->load->library('widget');
		$this->load->view('testes/corpo');
		
	}

}