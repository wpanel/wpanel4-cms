<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Videos.php gerado automaticamente para o WPanel CMS.
 * 
 * Data: 05/08/2015
 */ 

class Videos extends MX_Controller {

	var $content_vars = array();

	function __construct()
	{
		$this->auth->protect('videos');
		$this->load->model('video');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{

		$this->load->library('table');

		$this->table->set_template(array('table_open'  => '<table id="grid" class="table table-striped">'));
		$this->table->set_heading('Id', 'Titulo', 'Descricao', 'Status', 'Ações');
		$query = $this->video->get_list()->result();

		foreach($query as $row)
		{
			$this->table->add_row(
				$row->id,
				$row->titulo,
				$row->descricao,
				status_post($row->status),
				div(array('class'=>'btn-group btn-group-sm')).
				anchor('admin/videos/edit/'.$row->id, glyphicon('edit'), array('class' => 'btn btn-default')).
				'<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/videos/delete/'.$row->id).'\');">'.glyphicon('trash').'</button>'.
				div(null,true)
			);
		}

		$this->content_vars['listagem'] = $this->table->generate();
		$this->wpanel->load_view('videos/index', $this->content_vars);
	}

	public function add()
	{

		// Configure as regras de validação aqui:
		$this->form_validation->set_rules('titulo', 'Título', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->wpanel->load_view('videos/add', $this->content_vars);
		} else {

			$dados = array();
			$dados['titulo'] = $this->input->post('titulo');
			$dados['descricao'] = $this->input->post('descricao');
			$dados['link'] = $this->get_youtube_code($this->input->post('link'));
			$dados['created'] = date('Y-m-d H:i:s');
			$dados['updated'] = date('Y-m-d H:i:s');
			$dados['status'] = $this->input->post('status');

			if($this->video->save($dados))
			{
				$this->session->set_flashdata('msg_sistema', 'Registro salvo com sucesso.');
				redirect('admin/videos');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o registro.');
				redirect('admin/videos');
			}
		}
	}

	public function edit($id = null)
	{

		// Configure as regras de validação aqui:
		$this->form_validation->set_rules('titulo', 'Título', 'required');

		if($this->form_validation->run() == FALSE)
		{
			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Registro inexistente.');
				redirect('admin/videos');
			}
			$this->content_vars['row'] = $this->video->get_by_id($id)->row();
			$this->wpanel->load_view('videos/edit', $this->content_vars);
		} else {

			$dados = array();
			$dados['titulo'] = $this->input->post('titulo');
			$dados['descricao'] = $this->input->post('descricao');
			$dados['link'] = $this->get_youtube_code($this->input->post('link'));
			$dados['updated'] = date('Y-m-d H:i:s');
			$dados['status'] = $this->input->post('status');

			if($this->video->update($id, $dados))
			{
				$this->session->set_flashdata('msg_sistema', 'Registro salvo com sucesso.');
				redirect('admin/videos');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o registro.');
				redirect('admin/videos');
			}
		}
	}

	public function delete($id = null)
	{

		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Registro inexistente.');
			redirect('admin/videos');
		}

		if($this->video->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Registro excluído com sucesso.');
			redirect('admin/videos');
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir o registro.');
			redirect('admin/videos');
		}
	}

	private function get_youtube_code($url)
	{
		$ex = explode('?v=', $url);
		return $ex[1];
	}

	/* append-here */

}
