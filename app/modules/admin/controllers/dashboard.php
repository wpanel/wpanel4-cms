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

		$this->auth->protect('dashboard');
		
		$layout_vars = array();
		$content_vars = array();

		//----------------------------------------------------------------------------------------------------
		// Calcula os totais dos banners
		//----------------------------------------------------------------------------------------------------
		$this->db->like('status', '1');
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
		$total_posts_rascunhos = $this->db->count_all_results();

		$content_vars['total_posts_publicados'] = $total_posts_publicados;
		$content_vars['total_posts_rascunhos'] = $total_posts_rascunhos;
		$content_vars['total_posts'] = $this->db->count_all('posts');
		//----------------------------------------------------------------------------------------------------

		$this->wpanel->load_view('dashboard/index', $content_vars);

	}
} 

//END Class dashboard.
