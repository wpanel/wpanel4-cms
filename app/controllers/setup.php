<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends CI_Controller
{

	var $layout_vars = array();
	var $content_vars = array();

	function __construct()
	{

		parent::__construct();

		$this->load->library('migration');
		$this->load->model('user');

	}

	public function index()
	{

		$this->load->view('setup/index', $this->layout_vars);

	}

	/**
	 * Este método executa a atualiação do banco de dados do WPanel CMS.
	 * Execute-o durante a instalação e a cada atualização que fizer.
	 */
	public function migrate($version = null)
	{
		if($version == null){
			if($this->migration->latest())
			{
				redirect('setup/firstadmin');
			} else {
				echo '<h2>Ocorreram erros:</h2>';
				echo $this->migration->error_string();
			}
		} else {
			if($this->migration->version($version))
			{
				redirect('setup/firstadmin');
			} else {
				echo '<h2>Ocorreram erros:</h2>';
				echo $this->migration->error_string();
			}
		}
	}

	/**
	 * Este método faz o cadastro do primeiro administrador do wpanel.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function firstadmin()
	{

		/**
		 * Verifica se já existe algum usuário cadastrado.
		 */
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

			$this->load->view('setup/firstadmin', $this->layout_vars);

		} else {

			$dados_save = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'skin' => 'blue',
				'role' => 'admin',
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
				'status' => 1
			);

			if($this->user->save($dados_save))
			{
				$this->session->set_flashdata('msg_sistema', 'Usuário salvo com sucesso.');
				redirect('admin/dashboard/login');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
				redirect('admin/dashboard/firstadmin');
			}
		}
	}
}