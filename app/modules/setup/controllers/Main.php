<?php 
/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * -------------------------------------------------------------------------------------------------
 * Classe Setup()
 * 
 * Esta classe faz a instalação (configuração) inicial do Wpanel CMS
 * seguindo os seguintes passos:
 *
 * 1- Mostra um formulário para o usuário informar os dados da conexão;
 * 2- Gera o arquivo /app/config/database.php com os dados informados;
 * 3- Mostra um formulário para o usuário cadastrar o primeiro administrador;
 * 4- Salva os dados do administrador e direciona o usuário para a tela de login;
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.2.2
 * -------------------------------------------------------------------------------------------------
 */
class Main extends MX_Controller
{

	var $layout_vars = array();
	var $content_vars = array();

	function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	/**
	 * ---------------------------------------------------------------------------------------------
	 * Este método mostra o formulário de configuração da conexão com
	 * o banco de dados e efetua o processo de gerar o arquivo de
	 * configuração da conexão do wpanelcms.
	 *
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 * @return mixed
	 * ---------------------------------------------------------------------------------------------
	 */
	public function index()
	{
		
		$temp_url = '';

		/*
		 * -----------------------------------------------------------------------------------------
		 * Defini as regras de validação do formulário
		 * * ---------------------------------------------------------------------------------------
		 */
		if($this->input->post('tipo_database') == 'mysql')
			$this->form_validation->set_rules('servername', 'Servidor MySQL', 'required');
		$this->form_validation->set_rules('databasename', 'Base de dados', 'required');
		if($this->input->post('tipo_database') == 'mysql')
			$this->form_validation->set_rules('username', 'Usuário', 'required');

		if ($this->form_validation->run() == FALSE){

			if($this->config->item('base_url') == 'http://localhost/'){
				$temp_url = '../';
			} else {
				$temp_url = base_url();
			}

			$this->layout_vars['url'] = $temp_url;

			$this->load->view('setup/index', $this->layout_vars);
		}
		else {

			$data_install = array(
				'siteurl' => $this->input->post('siteurl'),
				'urlamigavel' => $this->input->post('urlamigavel'),
				'usaextensao' => $this->input->post('usaextensao'),
				'tipo_database' => $this->input->post('tipo_database'),
				'servername' => $this->input->post('servername'),
				'databasename' => $this->input->post('databasename'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);

			$this->load->library('install');
			$this->install->initialize($data_install);

			if(!$this->install->get_config()){
				$this->session->set_flashdata('msg_setup', 'Erro na criação do arquivo /app/config/config.php.');
				redirect('setup');
			} else if(!$this->install->get_json()){
				$this->session->set_flashdata('msg_setup', 'Erro na criação do arquivo /app/config/config.json.');
				redirect('setup');
			} else if(!$this->install->get_database()){
				$this->session->set_flashdata('msg_setup', 'Erro na criação do arquivo /app/config/database.php.');
				redirect('setup');
			} else if(!$this->install->get_migrate()){
				$this->session->set_flashdata('msg_setup', 'Houve um erro ao criar a base de dados.');
				redirect('setup');
			} else {
				redirect('setup/firstadmin');
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

		$this->load->model('user');

		/**
		 * Verifica se já existe algum usuário cadastrado.
		 */
		if ($this->user->inicial_user() == true)
		{
			redirect('admin/login');
		}
		
		$this->form_validation->set_rules('username', 'Nome de usuário', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required|md5');
		$this->form_validation->set_rules('name', 'Nome completo', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

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
				'permissions' => serialize(array()),
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
				'status' => 1
			);

			if($this->user->save($dados_save))
			{
				$this->session->set_flashdata('msg_sistema', 'Usuário salvo com sucesso.');
				redirect('admin/login');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
				redirect('setup/firstadmin');
			}
		}
	}
}