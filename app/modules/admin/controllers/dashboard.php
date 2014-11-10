<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Esta classe forma o conjunto de funcionalidades do Dashboard do Wpanel
 *
 * @package Wpanel
 * @author Eliel de Paula <elieldepaula@gmail.com>
 **/
class Dashboard extends MX_Controller {

	function __construct()
	{
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{

		$this->auth->protect('admin');
		
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

		$layout_vars['content'] = $this->load->view('dashboard', $content_vars, TRUE);

		$this->load->view('layout', $layout_vars);

	}

	/**
	 * Este método faz o login do usuário no wpanel.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function login()
	{
		$this->load->model('user');
		if ($this->user->inicial_user() == false)
		{
			redirect('admin/dashboard/firstadmin');
		}

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->load->view('login');
		} 
		else 
		{
			$conf_login = array('user_field' => $_POST['email'],'pass_field' => $_POST['password']);
			$this->auth->login($conf_login);
		}
	}

	/**
	 * Este método faz o logout do usuário.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function logout()
	{
		$this->auth->logout();
	}

	/**
	 * Este método faz o cadastro do primeiro administrador do wpanel.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function firstadmin()
	{

		$this->load->model('user');
		if ($this->user->inicial_user() == true)
		{
			redirect('admin/dashboard/login');
		}
		
		$this->form_validation->set_rules('username', 'Nome de usuário', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required|md5');
		$this->form_validation->set_rules('name', 'Nome completo', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');

		if ($this->form_validation->run() == FALSE)
		{

			$layout_vars = array();
			$content_vars = array();

			$this->load->view('dashboard_firstadmin', $layout_vars);

		} 
		else 
		{

			$dados_save = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'role' => 'admin',
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
				'status' => 1
			);

			if($this->user->save($dados_save))
			{
				$this->session->set_flashdata('msg_sistema', 'Usuário salvo com sucesso.');
				redirect('admin/dashboard/login');
			} 
			else 
			{
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
				redirect('admin/dashboard/firstadmin');
			}
		}
	}
} //END Class dashboard.
