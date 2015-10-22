<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class banners extends MX_Controller {
	
	function __construct()
	{
		$this->auth->protect('banners');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{
		$this->load->model('banner');
		$this->load->library('table');

		$layout_vars = array();
		$content_vars = array();

		// Template da tabela
		$this->table->set_template(array('table_open'  => '<table id="grid" class="table table-striped">')); 
		$this->table->set_heading('#', 'Título', 'Posição', 'Ordem', 'Status', 'Ações');
		$query = $this->banner->get_list();

		foreach($query->result() as $row)
		{
			$this->table->add_row(
				$row->id, 
				$row->title, 
				$row->position,
				$row->order,
				status_post($row->status), 
				div(array('class'=>'btn-group btn-group-sm')).
				anchor('admin/banners/edit/'.$row->id, glyphicon('edit'), array('class' => 'btn btn-default')).
				'<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/banners/delete/' . $row->id).'\');">'.glyphicon('trash').'</button>' .
				div(null,true)
				);
		}

		$content_vars['listagem'] = $this->table->generate();
		$this->wpanel->load_view('banners/index', $content_vars);
	}	

	public function add()
	{
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('title', 'Título', 'required');
		$this->form_validation->set_rules('order', 'Ordem', 'required');
		$this->form_validation->set_rules('position', 'Posição', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->wpanel->load_view('banners/add', $content_vars);
		} else {

			$this->load->model('banner');

			$dados_save = array();
			$dados_save['user_id'] = $this->auth->get_userid();
			$dados_save['title'] = $this->input->post('title');
			$dados_save['order'] = $this->input->post('order');
			$dados_save['position'] = $this->input->post('position');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['created'] = date('Y-m-d H:i:s');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['content'] = $this->banner->upload_media('banners', 'gif|jpg|png');

			$new_post = $this->banner->save($dados_save);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Banner salvo com sucesso.');
				redirect('admin/banners');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o banner.');
				redirect('admin/banners');
			}

		}
	}	

	public function edit($id = null)
	{
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('title', 'Título', 'required');
		$this->form_validation->set_rules('order', 'Ordem', 'required');
		$this->form_validation->set_rules('position', 'Posição', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Banner inexistente.');
				redirect('admin/banners');
			}

			$this->load->model('banner');
			$content_vars['id'] = $id;
			$content_vars['row'] = $this->banner->get_by_id($id)->row();
			$this->wpanel->load_view('banners/edit', $content_vars);

		} else {

			$this->load->model('banner');

			$dados_save = array();
			$dados_save['title'] = $this->input->post('title');
			$dados_save['order'] = $this->input->post('order');
			$dados_save['position'] = $this->input->post('position');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			
			if($this->input->post('alterar_imagem')=='1')
			{
				$banner = $this->banner->get_by_id($id)->row();
				$this->banner->remove_media('banners/' . $banner->content);

				$dados_save['content'] = $this->banner->upload_media('banners', 'gif|jpg|png');
			}

			$new_post = $this->banner->update($id, $dados_save);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Banner salvo com sucesso.');
				redirect('admin/banners');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o banner.');
				redirect('admin/banners');
			}

		}
	}	

	public function delete($id = null)
	{

		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Banner inexistente.');
			redirect('admin/banners');
		}

		// Remove o arquivo do banner.
		$this->load->model('banner');
		$banner = $this->banner->get_by_id($id)->row();
		$this->banner->remove_media('banners/' . $banner->content);

		if($this->banner->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Banner excluído com sucesso.');
			redirect('admin/banners');
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir o banner.');
			redirect('admin/banners');
		}
	}

}