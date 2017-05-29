<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
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
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class albuns extends MX_Controller
{

    function __construct()
    {
        $this->auth->check_permission();
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
    }

    public function index()
    {
        $this->load->model('album');
        $this->load->library('table');

        $layout_vars = array();
        $content_vars = array();

        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('#', 'Capa', 'Título', 'Data', 'Status', 'Ações');
        $query = $this->album->get_list();

        foreach ($query->result() as $row)
        {

            $capa_properties = array(
                'src' => base_url() . '/media/capas/' . $row->capa,
                'class' => 'img-responsive',
                'width' => '120',
                'alt' => $row->titulo
            );
            $capa = img($capa_properties);

            $this->table->add_row(
                    $row->id, $capa, anchor('admin/fotos/index/' . $row->id, glyphicon('picture') . $row->titulo), mdate('%d/%m/%Y - %H:%i', strtotime($row->created)), status_post($row->status), div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/fotos/index/' . $row->id, glyphicon('picture'), array('class' => 'btn btn-default')) .
                    anchor('admin/albuns/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/albuns/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }

        $content_vars['listagem'] = $this->table->generate();
        $this->wpanel->load_view('albuns/index', $content_vars);
    }

    public function add()
    {
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('titulo', 'Título', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->wpanel->load_view('albuns/add', $content_vars);
        } else
        {

            $this->load->model('album');

            $dados_save = array();
            $dados_save['user_id'] = $this->auth->get_login_data('id');
            $dados_save['titulo'] = $this->input->post('titulo');
            $dados_save['descricao'] = $this->input->post('descricao');
            $dados_save['status'] = $this->input->post('status');
            $dados_save['created'] = date('Y-m-d H:i:s');
            $dados_save['updated'] = date('Y-m-d H:i:s');
            $dados_save['capa'] = $this->album->upload_media('capas');

            $new_post = $this->album->save($dados_save);
            mkdir('./media/albuns/' . $new_post);

            if ($new_post)
            {
                $this->session->set_flashdata('msg_sistema', 'Album salvo com sucesso.');
                redirect('admin/albuns');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o album.');
                redirect('admin/albuns');
            }
        }
    }

    public function edit($id = null)
    {
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('titulo', 'Título', 'required');

        if ($this->form_validation->run() == FALSE)
        {

            if ($id == null)
            {
                $this->session->set_flashdata('msg_sistema', 'Album inexistente.');
                redirect('admin/albuns');
            }

            $this->load->model('album');
            $content_vars['id'] = $id;
            $content_vars['row'] = $this->album->get_by_id($id)->row();
            $this->wpanel->load_view('albuns/edit', $content_vars);
        } else
        {

            $this->load->model('album');

            $dados_save = array();
            $dados_save['titulo'] = $this->input->post('titulo');
            $dados_save['descricao'] = $this->input->post('descricao');
            $dados_save['status'] = $this->input->post('status');
            $dados_save['updated'] = date('Y-m-d H:i:s');

            if ($this->input->post('alterar_imagem') == '1')
            {
                $query = $this->album->get_by_id($id)->row();
                $this->album->remove_media('capas/' . $query->capa);
                $dados_save['capa'] = $this->album->upload_media('capas');
            }

            $new_post = $this->album->update($id, $dados_save);

            if ($new_post)
            {
                $this->session->set_flashdata('msg_sistema', 'Album salvo com sucesso.');
                redirect('admin/albuns');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o álbum.');
                redirect('admin/albuns');
            }
        }
    }

    public function delete($id = null)
    {

        if ($id == null)
        {
            $this->session->set_flashdata('msg_sistema', 'Album inexistente.');
            redirect('admin/albuns');
        }

        $this->load->model(array('album', 'foto'));
        $this->foto->delete_by_album($id);
        $query = $this->album->get_by_id($id)->row();
        $this->album->remove_media('capas/' . $query->capa);

        if ($this->album->delete($id))
        {
            $this->session->set_flashdata('msg_sistema', 'Album excluído com sucesso.');
            redirect('admin/albuns');
        } else
        {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o album.');
            redirect('admin/albuns');
        }
    }

}
