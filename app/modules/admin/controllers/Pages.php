<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Este é o controller de categorias, usado principalmente
| no painel de controle do site.
|
| @author Eliel de Paula <elieldepaula@gmail.com>
| @since 21/10/2014
|--------------------------------------------------------------------------
*/

class Pages extends MX_Controller {

	function __construct()
	{
		$this->auth->protect('pages');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{
		$this->load->model('post');
		$this->load->library('table');

		$layout_vars = array();
		$content_vars = array();

		// Template da tabela
		$this->table->set_template(array('table_open'  => '<table id="grid" class="table table-striped">')); 
		$this->table->set_heading('#', 'Título', 'Data', 'Status', 'Ações');
		$query = $this->post->get_by_field('page','1');

		foreach($query->result() as $row)
		{
			$this->table->add_row(
				$row->id, 
				$row->title,
				mdate('%d/%m/%Y', strtotime($row->created)), 
				status_post($row->status),
				// Ícones de ações
				div(array('class'=>'btn-group btn-group-sm')).
				anchor('admin/pages/edit/'.$row->id, glyphicon('edit'), array('class' => 'btn btn-default')).
				'<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/pages/delete/' . $row->id).'\');">'.glyphicon('trash').'</button>' .
				div(null,true)
			);
		}

		$content_vars['listagem'] = $this->table->generate();
		$this->wpanel->load_view('pages/index', $content_vars);
	}

	public function add()
	{
		
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('title', 'Título', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			$this->wpanel->load_view('pages/add', $content_vars);

		} else {

			$this->load->model('post');

			$dados_save = array();
			$dados_save['user_id'] = $this->auth->get_userid();
			$dados_save['title'] = $this->input->post('title');
			$dados_save['description'] = $this->input->post('description');
			$dados_save['link'] = strtolower(url_title(convert_accented_characters($this->input->post('title'))));
			$dados_save['content'] = $this->input->post('content');
			$dados_save['tags'] = $this->input->post('tags');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['created'] = date('Y-m-d H:i:s');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['image'] = $this->post->upload_media('capas');
			// Identifica se é uma página ou uma postagem
			// 0=post, 1=Página
			$dados_save['page'] = '1';

			$new_post = $this->post->save($dados_save);

			if($new_post)
			{
				// Salva o relacionamento das categorias
				$this->load->model('post_categoria');

				foreach($this->input->post('category_id') as $cat_id){
					$cat_save = array();
					$cat_save['post_id'] = $new_post;
					$cat_save['category_id'] = $cat_id;
					$this->post_categoria->save($cat_save);
				}

				$this->session->set_flashdata('msg_sistema', 'Página salva com sucesso.');
				redirect('admin/pages');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar a página.');
				redirect('admin/pages');
			}

		}
	}

	public function edit($id = null)
	{
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('title', 'Título', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Página inexistente.');
				redirect('admin/pages');
			}

			$this->load->model('post');

			$content_vars['id'] = $id;
			$content_vars['row'] = $this->post->get_by_id($id)->row();
			$this->wpanel->load_view('pages/edit', $content_vars);

		} else {

			$this->load->model('post');

			$dados_save = array();
			$dados_save['title'] = $this->input->post('title');
			$dados_save['description'] = $this->input->post('description');
			$dados_save['link'] = strtolower(url_title(convert_accented_characters($this->input->post('title'))));
			$dados_save['content'] = $this->input->post('content');
			$dados_save['tags'] = $this->input->post('tags');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			// Identifica se é uma página ou uma postagem
			// 0=post, 1=Página
			$dados_save['page'] = '1';
			
			if($this->input->post('alterar_imagem')=='1')
			{
				$postagem = $this->post->get_by_id($id)->row();
				$this->post->remove_media('capas/' . $postagem->image);
				$dados_save['image'] = $this->post->upload_media('capas');
			}

			$upd_post = $this->post->update($id, $dados_save);

			if($upd_post)
			{
				// Salva o relacionamento das categorias.
				$this->load->model('post_categoria');
				// Apaga os relacionamentos anteriores.
				$this->post_categoria->delete_by_post($id);
				// Cadastra as alterações.
				foreach($this->input->post('category_id') as $cat_id){
					$cat_save = array();
					$cat_save['post_id'] = $id;
					$cat_save['category_id'] = $cat_id;
					$this->post_categoria->save($cat_save);
				}

				$this->session->set_flashdata('msg_sistema', 'Página salva com sucesso.');
				redirect('admin/pages');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar a página.');
				redirect('admin/pages');
			}

		}
	}

	public function delete($id = null)
	{

		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Página inexistente.');
			redirect('admin/pages');
		}

		$this->load->model('post');

		$postagem = $this->post->get_by_id($id)->row();
		$this->post->remove_media('capas/' . $postagem->image);

		if($this->post->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Página excluída com sucesso.');
			redirect('admin/pages');
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir a página.');
			redirect('admin/pages');
		}
	}

}