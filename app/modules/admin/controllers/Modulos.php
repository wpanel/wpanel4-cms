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
 * Modules itens class.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
 */
class Modulos extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('module', 'module_action');
        parent::__construct();
        // Somente root pode acessar este módulo especial.
        if (!$this->auth->is_root())
            $this->set_message('Você não tem permissão para acessar este módulo.', 'danger', 'admin');
    }

    /**
     * List of modules.
     *
     * @return mixed
     */
    public function index()
    {
        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('#', 'Nome', 'Ícone', 'No menu', 'Ações');
        $query = $this->module->find_all();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->name, $row->icon, sim_nao($row->show_in_menu),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/modulos/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/modulos/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * New module.
     */
    public function add()
    {
        $this->form_validation->set_rules('name', 'Nome', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->render();
        } else
        {
            $data = array();
            $data['name'] = $this->input->post('name');
            $data['icon'] = $this->input->post('icon');
            if ($this->input->post('show_in_menu') == '1')
                $data['show_in_menu'] = '1';
            else
                $data['show_in_menu'] = '0';
            $data['order'] = 0;

            $new_module = $this->module->insert($data);
            if ($new_module)
                $this->set_message('Registro salvo com sucesso.', 'success', 'admin/modulos/edit/' . $new_module);
            else
                $this->set_message('Erro ao salvar o registro.', 'danger', 'admin/modulos');
        }
    }

    /**
     * Edit an module.
     * 
     * @param int $id
     */
    public function edit($id = NULL)
    {
        $this->form_validation->set_rules('name', 'Nome', 'required');
        if ($this->form_validation->run() == FALSE)
        {

            if ($id == NULL)
                $this->set_message('Registro inexistente.', 'danger', 'admin/modulos');

            $query = $this->module->find($id);
            $this->set_var('actions_list', $this->actions_list($query->id));
            $this->set_var('row', $query);

            $this->render();
        } else
        {

            $data = array();
            $data['name'] = $this->input->post('name');
            $data['icon'] = $this->input->post('icon');

            if ($this->input->post('show_in_menu') == '1')
                $data['show_in_menu'] = '1';
            else
                $data['show_in_menu'] = '0';

            $data['order'] = 0;

            if ($this->module->update($id, $data))
                $this->set_message('Registro salvo com sucesso.', 'success', 'admin/modulos');
            else
                $this->set_message('Erro ao salvar o registro.', 'danger', 'admin/modulos');
        }
    }

    /**
     * Delete an module.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message('Registro inexistente.', 'danger', 'admin/modulos');

        if ($this->module->delete($id))
        {
            $this->module_action->delete_by('module_id', $id);
            $this->set_message('Registro excluído com sucesso.', 'success', 'admin/modulos');
        } else
            $this->set_message('Erro ao excluir o registro.', 'danger', 'admin/modulos');
    }

    /**
     * List the actions (itens) from an module.
     *
     * @param int $module_id
     */
    private function actions_list($module_id = NULL)
    {
        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('#', 'Descrição', 'Link', 'Lista branca', 'Ações');
        $query = $this->module_action->find_many_by('module_id', $module_id);
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->description, $row->link, sim_nao($row->whitelist),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/moduloitens/edit/' . $row->id . '/' . $row->module_id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button type="button" class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/moduloitens/delete/' . $row->id . '/' . $row->module_id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        return $this->table->generate();
    }

}

// End of file modules/admin/controllers/Modulos.php
