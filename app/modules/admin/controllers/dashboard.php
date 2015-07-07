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

		//$layout_vars['content'] = $this->load->view('dashboard', $content_vars, TRUE);

		//$this->load->view('layout', $layout_vars);
		$this->wpanel->load_view('dashboard/index', $content_vars);

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
			$this->load->load->view('layout/login');
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

			$this->load->view('/dashboard/firstadmin', $layout_vars);

		} 
		else 
		{

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
			} 
			else 
			{
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
				redirect('admin/dashboard/firstadmin');
			}
		}
	}
	
	/**
	 * Este método faz o procedimento de recuperação de senhas de usuários do wpanel.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function password_recover($recovery_key = null)
	{

		$this->load->library('email');

		if ($this->wpanel->get_config('usa_smtp') == 1) 
		{
			$conf_email = array();
			$conf_email['protocol'] = 'smtp';
			$conf_email['smtp_host'] = $this->wpanel->get_config('smtp_servidor');
			$conf_email['smtp_port'] = $this->wpanel->get_config('smtp_porta');
			$conf_email['smtp_user'] = $this->wpanel->get_config('smtp_usuario');
			$conf_email['smtp_pass'] = $this->wpanel->get_config('smtp_senha');
			$this->email->initialize($conf_email);
		}

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			if($recovery_key == null)
			{
				$this->load->view('dashboard/recovery');
			}
			else
			{

				$this->load->model('user');
				$chave	= explode(',', base64_decode(strrev($recovery_key)));
				$id		= $chave[0];
				$nome	= $chave[1];
				$email	= $chave[2];
				$senha  = md5('123mudar');

				$dados_save = array();
				$dados_save['password'] = $senha;

				if($this->user->update($id, $dados_save))
				{

					$mensagem = "";
					$mensagem .= "Olá ".$nome.", esta é uma mensagem automática, não responda este email. \n\n";
					$mensagem .= "Sua senha de acesso ao painel de controle foi redefinida com sucesso! ";
					$mensagem .= "Anote os seus novos dados: \n\n";
					$mensagem .= "Email: ".$email." \n";
					$mensagem .= "Senha: 123mudar \n\n";
					$mensagem .= "ATENÇÃO!!!\n\nMude a senha imediatamente após o login, esta é uma senha ";
					$mensagem .= "temporária e caso não seja alterada seu acesso será revogado. \n\n";

					$this->email->to($email);
					$this->email->from($this->wpanel->get_config('site_contato'), $this->wpanel->get_config('site_titulo'));
					$this->email->subject('Senha redefinida');
					$this->email->message($mensagem);
					$this->email->send();

					$this->session->set_flashdata('msg_auth', 'Sua senha foi redefinida e enviamos seus novos dados de acesso para seu email, caso não receba verifique sua caixa de SPAM.');
					redirect('admin/login');
				}
				else
				{
					$this->session->set_flashdata('msg_recover', 'Houve um problema e sua senha não pode ser redefinida, entre em contato conosco pelo email <b>'.$this->wpanel->get_config('site_contato').'</b>.');
					redirect('admin/repass');
				}
			}
		}
		else
		{

			$this->load->model('user');

			$query = $this->user->get_by_field('email', $this->input->post('email'))->row();

			if(count($query) >= 1)
			{

				$recovery_key	= strrev(base64_encode($query->id.','.$query->name.','.$query->email));
				$recovery_link	= base_url('admin/repass').'/'.$recovery_key;

				$mensagem = "";
				$mensagem .= "Olá ".$query->name.", esta é uma mensagem automática, não responda este email. \n\n";
				$mensagem .= "Recebemos uma solicitação de redefinição de senha de acesso ao seu painel de controle ";
				$mensagem .= "em nosso site. Para concluir a redefinição clique no link abaixo: \n\n";
				$mensagem .= "Link: ".$recovery_link." \n\n";
				$mensagem .= "Caso vocẽ não tenha solicitado a redefinição de sua senha por favor ignore esta mensagem. \n\n";
				$mensagem .= "Data/Hora da solicitação: ".date('d/m/Y H:i')."\n";
				$mensagem .= "IP da conexão: ".$_SERVER['REMOTE_ADDR']." \n\n";

				$this->email->to($query->email);
				$this->email->from($this->wpanel->get_config('site_contato'), $this->wpanel->get_config('site_titulo'));
				$this->email->subject('Redefinição de senha');
				$this->email->message($mensagem);
				$this->email->send();

				$this->session->set_flashdata('msg_auth', 'Enviamos as instruções para redefinição de sua senha no seu email informado no cadastro.');
				redirect('admin/login');
			}
			else
			{
				$this->session->set_flashdata('msg_recover', 'Usuário inexistente.');
				redirect('admin/repass');
			}
		}
	}
} //END Class dashboard.
