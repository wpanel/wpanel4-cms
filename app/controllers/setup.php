<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends CI_Controller
{

	var $layout_vars = array();
	var $content_vars = array();

	function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{

		$this->form_validation->set_rules('servername', 'Servidor MySQL', 'required');
		$this->form_validation->set_rules('databasename', 'Base de dados', 'required');
		$this->form_validation->set_rules('username', 'Usuário', 'required');

		if ($this->form_validation->run() == FALSE)
		{

			$this->load->view('setup/index', $this->layout_vars);

		} else {

			$this->load->helper('file');

			$data = "";
			$data .= "<?php if(!defined('BASEPATH')) exit('No direct script access allowed');\n\n";

			$data .= "\$active_group = ENVIRONMENT;\n";
			$data .= "\$active_record = TRUE;\n\n";

			$data .= "/**\n";
			$data .= " * Configurações para o ambiente de desenvolvimento.\n";
			$data .= " */\n";
			$data .= "\$db['development']['hostname'] = '".$this->input->post('servername')."';\n";
			$data .= "\$db['development']['username'] = '".$this->input->post('username')."';\n";
			$data .= "\$db['development']['password'] = '".$this->input->post('password')."';\n";
			$data .= "\$db['development']['database'] = '".$this->input->post('databasename')."';\n";
			$data .= "\$db['development']['dbdriver'] = 'mysql';\n";
			$data .= "\$db['development']['dbprefix'] = '';\n";
			$data .= "\$db['development']['pconnect'] = TRUE;\n";
			$data .= "\$db['development']['db_debug'] = TRUE;\n";
			$data .= "\$db['development']['cache_on'] = FALSE;\n";
			$data .= "\$db['development']['cachedir'] = '';\n";
			$data .= "\$db['development']['char_set'] = 'utf8';\n";
			$data .= "\$db['development']['dbcollat'] = 'utf8_general_ci';\n";
			$data .= "\$db['development']['swap_pre'] = '';\n";
			$data .= "\$db['development']['autoinit'] = TRUE;\n";
			$data .= "\$db['development']['stricton'] = FALSE;\n\n";

			$data .= "/**\n";
			$data .= " * Configurações para o ambiente de produção.\n";
			$data .= " */\n";
			$data .= "\$db['production']['hostname'] = '';\n";
			$data .= "\$db['production']['username'] = '';\n";
			$data .= "\$db['production']['password'] = '';\n";
			$data .= "\$db['production']['database'] = '';\n";
			$data .= "\$db['production']['dbdriver'] = 'mysql';\n";
			$data .= "\$db['production']['dbprefix'] = '';\n";
			$data .= "\$db['production']['pconnect'] = TRUE;\n";
			$data .= "\$db['production']['db_debug'] = TRUE;\n";
			$data .= "\$db['production']['cache_on'] = FALSE;\n";
			$data .= "\$db['production']['cachedir'] = '';\n";
			$data .= "\$db['production']['char_set'] = 'utf8';\n";
			$data .= "\$db['production']['dbcollat'] = 'utf8_general_ci';\n";
			$data .= "\$db['production']['swap_pre'] = '';\n";
			$data .= "\$db['production']['autoinit'] = TRUE;\n";
			$data .= "\$db['production']['stricton'] = FALSE;\n\n";

			if ( ! write_file('./app/config/database.php', $data))
			{
				$this->session->set_flashdata('msg_setup', 'Houve um erro durante o setup: Verifique se você deu permissão de escrita na pasta /app/config');
				redirect('setup');

			} else {
				redirect('setup/migrate');
			}
		}

	}

	/**
	 * Este método executa a atualiação do banco de dados do WPanel CMS.
	 * Execute-o durante a instalação e a cada atualização que fizer.
	 */
	public function migrate($version = null)
	{
		$this->load->library('migration');
		if($version == null){
			if($this->migration->latest())
			{
				redirect('setup/firstadmin');
			} else {
				$this->session->set_flashdata('msg_setup', 'Houve um erro durante o setup: ' . $this->migration->error_string());
				redirect('setup');
			}
		} else {
			if($this->migration->version($version))
			{
				redirect('setup/firstadmin');
			} else {
				$this->session->set_flashdata('msg_setup', 'Houve um erro durante o setup: ' . $this->migration->error_string());
				redirect('setup');
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