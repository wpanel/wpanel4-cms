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

class fotos extends MX_Controller {

	function __construct()
	{
		$this->auth->protect('albuns');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', 
			'</span></p>');
	}

	public function index($album_id)
	{
		$this->load->model('album');
		$this->load->model('foto');
		$this->load->library('table');

		$layout_vars = array();
		$content_vars = array();

		// Dados do álbum
		// $query_album = $this->album->get_by_id($album_id)->row();

		// Template da tabela
		$this->table->set_template(
			array('table_open'  => '<table id="grid" class="table table-striped">')
		);
		$this->table->set_heading('#', 'Imagem', 'Descricao', 'Data', 'Status', 'Ações');
		$query = $this->foto->get_by_field(
			'album_id', 
			$album_id, 
			array('field'=>'created', 'order'=>'desc')
		);

		foreach($query->result() as $row)
		{

			$capa_properties = array(
            	'src' => base_url() . '/media/albuns/'.$album_id . '/' . $row->filename,
            	'class' => 'img-responsive',
            	'width' => '120',
            	'alt' => $row->descricao
            );
            $imagem = img($capa_properties);

			$this->table->add_row(
				$row->id,
				$imagem,
				$row->descricao,
				mdate('%d/%m/%Y - %H:%i', strtotime($row->created)),
				status_post($row->status),
				div(array('class'=>'btn-group btn-group-sm')).
				anchor('admin/fotos/edit/'.$row->id, glyphicon('edit'), 
					array('class' => 'btn btn-default')).
				'<button class="btn btn-default" onClick="return confirmar(\'' . 
					site_url('admin/fotos/delete/' . $row->id) . '\');">' . 
			glyphicon('trash').'</button>' .
				div(null,true)
				);
		}

		$content_vars['album_id'] = $album_id;
		$content_vars['listagem'] = $this->table->generate();
		$this->wpanel->load_view('fotos/index', $content_vars);
	}

	public function add($album_id)
	{
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('descricao', 'Foto', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$content_vars['album_id'] = $album_id;
			$this->wpanel->load_view('fotos/add', $content_vars);
		} else {

			$this->load->model('foto');

			$dados_save = array();
			$dados_save['album_id'] = $album_id;
			$dados_save['descricao'] = $this->input->post('descricao');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['created'] = date('Y-m-d H:i:s');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['filename'] = $this->foto->upload_media('albuns/'.$album_id);

			$new_post = $this->foto->save($dados_save);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Foto salva com sucesso.');
				redirect('admin/fotos/index/'.$album_id);
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar a foto.');
				redirect('admin/fotos/index/'.$album_id);
			}
		}
	}

  public function addmass($album_id = null)
  {

    if($album_id == null)
    {
      $this->session->set_flashdata('msg_sistema', 'Álbum de fotos inexistente.');
      redirect('admin/fotos/index/'.$album_id);
    }

    $layout_vars = array();
    $content_vars = array();

    $this->form_validation->set_rules('descricao', 'Foto', 'required');

    if ($this->form_validation->run() == FALSE)
    {
      $content_vars['album_id'] = $album_id;
      $this->wpanel->load_view('fotos/addmass', $content_vars);
    } else {

      $this->load->model('foto');

      /* Faz o laço do upload */
      $pasta = './media/albuns/'.$album_id.'/';
      $fotos = $_FILES['fotos'];

      for($i = 0; $i < sizeof($fotos); $i++)
      {

        $nome = $album_id . '_' . time() . '_' . str_replace(array(' ', ',', '-'), '', 
        	$fotos["name"][$i]);
        $tmpname = $fotos["tmp_name"][$i];
        $caminho = $pasta . $nome;

        //TODO Fazer um tipo de validação aqui...
        if(move_uploaded_file($tmpname, $caminho))
        {

          $dados_save = array();
          $dados_save['album_id'] = $album_id;
          $dados_save['descricao'] = $this->input->post('descricao');
          $dados_save['status'] = $this->input->post('status');
          $dados_save['created'] = date('Y-m-d H:i:s');
          $dados_save['updated'] = date('Y-m-d H:i:s');
          $dados_save['filename'] = $nome;

          $uploads = $this->foto->save($dados_save);

        } else {
          $this->session->set_flashdata('msg_sistema', 'Não foi possível enviar as fotos.');
          redirect('admin/fotos/index/'.$album_id);
        }
      }
      /* Fim do laço do upload */

      $this->session->set_flashdata('msg_sistema', 'Fotos salvas com sucesso.');
      redirect('admin/fotos/index/'.$album_id);

    }
  }

	public function edit($id = null)
	{
		$layout_vars = array();
		$content_vars = array();

		$this->load->model('foto');
		$row = $this->foto->get_by_id($id)->row();

		$this->form_validation->set_rules('descricao', 'Descrição', 'required');

		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Foto inexistente.');
				redirect('admin/albuns');
			}

			$content_vars['id'] = $id;
			$content_vars['row'] = $row;
			$this->wpanel->load_view('fotos/edit', $content_vars);

		} else {

			$dados_save['descricao'] = $this->input->post('descricao');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['updated'] = date('Y-m-d H:i:s');

			if($this->input->post('alterar_imagem')=='1')
			{
				$query = $this->foto->get_by_id($id)->row();
				$this->foto->remove_media('albuns/' . $query->album_id . '/' . $query->filename);
				$dados_save['filename'] = $this->foto->upload_media('albuns/' . $query->album_id . '/');
			}

			$new_post = $this->foto->update($id, $dados_save);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Foto salva com sucesso.');
				redirect('admin/fotos/index/'.$row->album_id);
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar a foto.');
				redirect('admin/fotos/index/'.$row->album_id);
			}
		}
	}

	public function delete($id = null)
	{

		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Foto inexistente.');
			redirect('admin/albuns');
		}

		$this->load->model('foto');
		$qry_foto = $this->foto->get_by_id($id)->row();
		$this->foto->remove_media('albuns/' . $qry_foto->album_id . '/' . $qry_foto->filename);

		if($this->foto->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Foto excluída com sucesso.');
			redirect('admin/fotos/index/'.$qry_foto->album_id);
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir a foto.');
			redirect('admin/fotos/index/'.$qry_foto->album_id);
		}
	}
}
