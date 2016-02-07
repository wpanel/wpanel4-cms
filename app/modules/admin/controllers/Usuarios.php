<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Este é o controller de usuários, usado no painel de controle do site.
|
| @author Eliel de Paula <elieldepaula@gmail.com>
| @since 20/10/2014
|--------------------------------------------------------------------------
*/

class Usuarios extends MX_Controller {

	function __construct()
	{
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
		$this->load->model('user');
	}

	public function index()
	{
		$this->auth->protect('usuarios');
		$layout_vars = array();
		$content_vars = array();
        $roles = config_item('users_role');

		$content_vars['usuarios'] = $this->user->get_list()->result();
        $content_vars['roles'] = $roles;
		$this->wpanel->load_view('usuarios/index', $content_vars);
	}

	public function add()
	{
		$this->auth->protect('usuarios');
		$this->form_validation->set_rules('username', 'Nome de usuário', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required|md5');
		$this->form_validation->set_rules('name', 'Nome completo', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');

		if ($this->form_validation->run() == FALSE)
		{

			$layout_vars = array();
			$content_vars = array();

			$this->wpanel->load_view('usuarios/add', $content_vars);

		} else {

			$dados_save = array();
			$dados_save['name'] = $this->input->post('name');
			$dados_save['email'] = $this->input->post('email');
			$dados_save['skin'] = $this->input->post('skin');
			$dados_save['image'] = $this->user->upload_media('avatar');
			$dados_save['username'] = $this->input->post('username');
			$dados_save['password'] = $this->input->post('password');
			$dados_save['role'] = $this->input->post('role');
			$dados_save['created'] = date('Y-m-d H:i:s');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['permissions'] = serialize($this->input->post('permissions'));

			if($this->user->save($dados_save))
			{
				$this->session->set_flashdata('msg_sistema', 'Usuário salvo com sucesso.');
				redirect('admin/usuarios');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
				redirect('admin/usuarios');
			}
		}
	}

	public function edit($id = null)
	{

		$this->auth->protect('usuarios');

		// Verifica se altera a senha
		if($this->input->post('alterar_senha') == '1'){
			$this->form_validation->set_rules('password', 'Senha', 'required|md5');
		}
		
		$this->form_validation->set_rules('username', 'Nome de usuário', 'required');
		$this->form_validation->set_rules('name', 'Nome completo', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Usuário inexistente.');
				redirect('admin/usuarios');
			}

			$layout_vars = array();
			$content_vars = array();

			$content_vars['id'] = $id;
			$content_vars['row'] = $this->user->get_by_id($id)->row();
			$this->wpanel->load_view('usuarios/edit', $content_vars);

		} else {

			$dados_save = array();
			$dados_save['name'] = $this->input->post('name');
			$dados_save['email'] = $this->input->post('email');
			$dados_save['skin'] = $this->input->post('skin');
			$dados_save['username'] = $this->input->post('username');
			$dados_save['role'] = $this->input->post('role');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['permissions'] = serialize($this->input->post('permissions'));

			// Verifica se altera a imagem
			if($this->input->post('alterar_imagem') == '1'){
				$query = $this->user->get_by_id($id)->row();
				$this->user->remove_media('avatar/' . $query->image);
				$dados_save['image'] = $this->user->upload_media('avatar');
			}

			// Verifica se altera a senha.
			if($this->input->post('alterar_senha') == '1'){
				$dados_save['password'] = $this->input->post('password');
			}

			if($this->user->update($id, $dados_save))
			{
				if($this->input->post('alterar_senha') == '1'){
					redirect('admin/logout');
				} else {
					$this->session->set_flashdata('msg_sistema', 'Usuário salvo com sucesso.');
					redirect('admin/usuarios');
				}
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
				redirect('admin/usuarios');
			}
		}
	}

	public function delete($id = null)
	{

		$this->auth->protect('usuarios');

		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Usuário inexistente.');
			redirect('admin/usuarios');
		}

		if($this->user->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Usuário excluído com sucesso.');
			redirect('admin/usuarios');
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir o usuário.');
			redirect('admin/usuarios');
		}
	}

	public function profile()
	{
		
		$id = $this->wpanel->get_from_user('id');

		// Verifica se altera a senha
		if($this->input->post('alterar_senha') == '1'){
			$this->form_validation->set_rules('password', 'Senha', 'required|md5');
		}
		
		$this->form_validation->set_rules('username', 'Nome de usuário', 'required');
		$this->form_validation->set_rules('name', 'Nome completo', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Usuário inexistente.');
				redirect('admin/dashboard');
			}

			$layout_vars = array();
			$content_vars = array();

			$content_vars['id'] = $id;
			$content_vars['row'] = $this->user->get_by_id($id)->row();
			$this->wpanel->load_view('usuarios/profile', $content_vars);

		} else {

			$dados_save = array();
			$dados_save['name'] = $this->input->post('name');
			$dados_save['email'] = $this->input->post('email');
			$dados_save['skin'] = $this->input->post('skin');
			$dados_save['username'] = $this->input->post('username');
			$dados_save['updated'] = date('Y-m-d H:i:s');

			// Verifica se altera a imagem
			if($this->input->post('alterar_imagem') == '1'){
				$query = $this->user->get_by_id($id)->row();
				$this->user->remove_media('avatar/' . $query->image);
				$dados_save['image'] = $this->user->upload_media('avatar');
			}

			// Verifica se altera a senha.
			if($this->input->post('alterar_senha') == '1'){
				$dados_save['password'] = $this->input->post('password');
			}

			if($this->user->update($id, $dados_save))
			{
				if($this->input->post('alterar_senha') == '1'){
					redirect('admin/logout');
				} else {
					$this->session->set_flashdata('msg_sistema', 'Seus dados foram salvos com sucesso.');
					redirect('admin/usuarios/profile');
				}
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar os seus dados.');
				redirect('admin/usuarios/profile');
			}
		}
	}
}