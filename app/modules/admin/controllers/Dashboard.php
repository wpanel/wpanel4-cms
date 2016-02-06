<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Esta classe forma o conjunto de funcionalidades do Dashboard do Wpanel
 *
 * @package Wpanel
 * @author Eliel de Paula <dev@gelieldepaula.com.br>
 **/
class Dashboard extends MX_Controller {

	function __construct()
	{

		// Protege o acesso do dashboard independente de permissão.
		if(!$this->session->userdata('logged_in'))
			redirect('admin/logout');

		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
		$this->load->model('dash');
	}

	public function index()
	{

		$layout_vars = array();
		$content_vars = array();

		$content_vars['total_posts'] 	= $this->dash->calcula_totais('posts', '0');
		$content_vars['total_paginas'] 	= $this->dash->calcula_totais('posts', '1');
		$content_vars['total_agendas'] 	= $this->dash->calcula_totais('posts', '2');
		$content_vars['total_banners'] 	= $this->dash->calcula_totais('banners');
		$content_vars['total_albuns'] 	= $this->dash->calcula_totais('albuns');
		$content_vars['total_videos'] 	= $this->dash->calcula_totais('videos');
		//----------------------------------------------------------------------------------------------------

		$this->wpanel->load_view('dashboard/index', $content_vars);

	}
}