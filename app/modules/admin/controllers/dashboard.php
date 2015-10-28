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
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{

		// $this->auth->protect('dashboard'); // Protege a dashboard (???)
		
		$layout_vars = array();
		$content_vars = array();

		/**
		Fazer o resumo por usuário.
		*/

		//----------------------------------------------------------------------------------------------------
		// Calcula os totais dos banners
		//----------------------------------------------------------------------------------------------------
		/*$this->db->where('user_id', $this->wpanel->get_from_user('id'));
		$this->db->from('banners');
		$total_banners_publicados = $this->db->count_all_results();

		$this->db->like('status', '0');
		$this->db->from('banners');
		$total_banners_rascunhos = $this->db->count_all_results();

		$content_vars['total_banners_publicados'] = $total_banners_publicados;
		$content_vars['total_banners_rascunhos'] = $total_banners_rascunhos;
		$content_vars['total_banners'] = $this->db->count_all('banners');
		//----------------------------------------------------------------------------------------------------
		// Calcula os totais das postagens
		//----------------------------------------------------------------------------------------------------
		$this->db->like('status', '1');
		$this->db->from('posts');
		$total_posts_publicados = $this->db->count_all_results();

		$this->db->like('status', '0');
		$this->db->from('posts');
		$total_posts_rascunhos = $this->db->count_all_results();*/

		//$this->db->where('user_id', $this->wpanel->get_from_user('id'));

		$content_vars['total_posts'] = $this->calcula_totais('posts', '0');
		$content_vars['total_paginas'] = $this->calcula_totais('posts', '1');
		$content_vars['total_agendas'] = $this->calcula_totais('posts', '2');
		$content_vars['total_banners'] = $this->calcula_totais('banners');
		$content_vars['total_albuns'] = $this->calcula_totais('albuns');
		$content_vars['total_videos'] = $this->calcula_totais('videos');
		//----------------------------------------------------------------------------------------------------

		$this->wpanel->load_view('dashboard/index', $content_vars);

	}

	private function calcula_totais($modulo, $tipo = 0)
	{

		

		$this->db->where('user_id', $this->wpanel->get_from_user('id'));

		if($modulo == 'posts')
			$this->db->where('page', $tipo);
		
		$this->db->from($modulo);
		return $this->db->count_all_results();
	}
} 

//END Class dashboard.
