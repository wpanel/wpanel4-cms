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

/**
 * Video class
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
 */
class Videos extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'video';
        parent::__construct();
    }

    /**
     * List videos.
     */
    public function index()
    {
        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('Id', 'Titulo', 'Descricao', 'Status', 'Ações');
        $query = $this->video->find_all();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->titulo, $row->descricao, status_post($row->status), div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/videos/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/videos/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert video.
     */
    public function add()
    {
        $this->form_validation->set_rules('titulo', 'Título', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['link'] = $this->get_youtube_code($this->input->post('link'));
            $data['status'] = $this->input->post('status');
            if ($this->video->insert($data))
                $this->set_message('Vídeo salvo com sucesso!', 'success', 'admin/videos');
            else
                $this->set_message('Erro ao salvar o vídeo', 'danger', 'admin/videos');
        }
    }

    /**
     * Edit an video.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('titulo', 'Título', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Vídeo inexistente.', 'info', 'admin/videos');
            $this->set_var('row', $this->video->find($id));
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['link'] = $this->get_youtube_code($this->input->post('link'));
            $data['status'] = $this->input->post('status');
            if ($this->video->update($id, $data))
                $this->set_message('Vídeo salvo com sucesso!', 'success', 'admin/videos');
            else
                $this->set_message('Erro ao salvar o vídeo', 'danger', 'admin/videos');
        }
    }

    /**
     * Delete an video.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message('Vídeo inexistente.', 'info', 'admin/videos');
        if ($this->video->delete($id))
            $this->set_message('Vídeo excluído com sucesso!', 'success', 'admin/videos');
        else
            $this->set_message('Erro ao excluir o vídeo', 'danger', 'admin/videos');
    }

    /**
     * Return youtube code by an URI
     * 
     * @param string $url
     * @return string
     */
    private function get_youtube_code($url)
    {
        $ex = explode('?v=', $url);
        return $ex[1];
    }

    /* append-here */
}
