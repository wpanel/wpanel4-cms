<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct()
	{
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{
		// Ativa o cache da página por 15 minutos.
		// $this->output->cache(15);

		$this->auth->protect('admin');
		
		$layout_vars = array();
		$content_vars = array();

		// Calcula os totais dos imóveis.
		//----------------------------------------------------------------------------------------------------
		// $this->db->like('status', '1');
		// $this->db->from('imoveis');
		// $total_imoveis_publicados = $this->db->count_all_results();

		// $this->db->like('status', '0');
		// $this->db->from('imoveis');
		// $total_imoveis_rascunhos = $this->db->count_all_results();

		// $content_vars['total_imoveis_publicados'] = $total_imoveis_publicados;
		// $content_vars['total_imoveis_rascunhos'] = $total_imoveis_rascunhos;
		// $content_vars['total_imoveis'] = $this->db->count_all('imoveis');
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

		$layout_vars['content'] = $this->load->view('dashboard', $content_vars, TRUE);

		$this->load->view('layout', $layout_vars);

	}

	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->load->view('login');
		} else {
			$conf_login = array('user_field' => $_POST['email'],'pass_field' => $_POST['password']);
			$this->auth->login($conf_login);
		}
	}

	public function logout()
	{
		$this->auth->logout();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/dashboard.php */