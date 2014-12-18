<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class erros extends MX_Controller {

	public function index()
	{
		echo "Mostra os erros do site";
	}

	public function err_404()
	{
		$this->load->view('erro_404');
	}

}