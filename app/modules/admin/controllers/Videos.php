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

class Videos extends MX_Controller {

	var $content_vars = array();

	function __construct()
	{
		$this->auth->check_permission();
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
				div(array('class'=>'btn-group btn-group-xs')).
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
			$dados['user_id'] = $this->auth->get_userid();
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
