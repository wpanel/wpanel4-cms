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
 * Este é o controller de categorias, usado principalmente
 * no painel de controle do site.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
 */
class Categorias extends Authenticated_Controller
{

    function __construct()
    {
        $this->model_file = 'categoria';
        parent::__construct();
    }

    /**
     * List of categories.
     */
    public function index()
    {
        $this->load->library('table');
        $posts_views = config_item('posts_views');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('#', 'Título', 'Categoria-pai', 'Visão', 'Ações');
        $query = $this->categoria->find_all();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->title, $this->categoria->get_title_by_id($row->category_id), $posts_views[$row->view], div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/categorias/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/categorias/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert new category.
     */
    public function add()
    {
        $this->form_validation->set_rules('title', 'Título', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // Prepara a lista de categorias.
            $query = $this->categoria->find_all();
            $options = array();
            $options[0] = 'Sem categoria';
            foreach ($query as $row)
            {
                $options[$row->id] = $row->title;
            }
            $this->set_var('options', $options);
            $this->render();
        } else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['link'] = url_title(convert_accented_characters($this->input->post('title')));
            $data['category_id'] = $this->input->post('category_id');
            $data['view'] = $this->input->post('view');
            if ($this->categoria->insert($data))
                $this->set_message('Categoria salva com sucesso!', 'success', 'admin/categorias');
            else
                $this->set_message('Erro ao salvar a categoria.', 'danger', 'admin/categorias');
        }
    }

    /**
     * Edit an category.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('title', 'Título', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Categoria inexistente.', 'info', 'admin/categorias');
            // Prepara a lista de categorias.
            $query = $this->categoria->find_all();
            $options = array();
            $options[0] = 'Sem categoria';
            foreach ($query as $row)
            {
                $options[$row->id] = $row->title;
            }
            $this->set_var('row', $this->categoria->find($id));
            $this->set_var('options', $options);
            $this->render();
        } else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['link'] = url_title(convert_accented_characters($this->input->post('title')));
            $data['category_id'] = $this->input->post('category_id');
            $data['view'] = $this->input->post('view');
            if ($this->categoria->update($id, $data))
                $this->set_message('Categoria salva com sucesso!', 'success', 'admin/categorias');
            else
                $this->set_message('Erro ao salvar a categoria.', 'danger', 'admin/categorias');
        }
    }

    /**
     * Delete an category.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message('Categoria inexistente.', 'info', 'admin/categorias');
        if ($this->categoria->delete($id))
            $this->set_message('Categoria excluída com sucesso!', 'success', 'admin/categorias');
        else
            $this->set_message('Erro ao excluir a categoria.', 'danger', 'admin/categorias');
    }

}
