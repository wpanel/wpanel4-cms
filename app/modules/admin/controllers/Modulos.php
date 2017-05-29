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
 * Esta é a classe do módulo de administração Modulos, ela foi
 * gerada automaticamente pela ferramenta Wpanel-GEN para a criação
 * de códigos padrão para o Wpanel CMS.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @version		0.0.1
 */
class Modulos extends MX_Controller
{

    /**
     * Método construtor.
     */
    function __construct()
    {
        $this->auth->check_permission();
        $this->load->model(array('module', 'module_action'));
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
    }

    /**
     * Mostra a lista de registros.
     * 
     * @return mixed
     */
    public function index()
    {
        $this->load->library('table');
        $layout_vars = array();
        $content_vars = array();
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        //TODO Revise as colunas da tabela.
        $this->table->set_heading('#', 'Nome', 'Ícone', 'No menu', 'Ações');
        $query = $this->module->get_list()->result();
        foreach ($query as $row)
        {
            //TODO Revise as colunas da lista.
            $this->table->add_row(
                    $row->id, $row->name, $row->icon, sim_nao($row->show_in_menu),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/modulos/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/modulos/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $content_vars['listagem'] = $this->table->generate();
        $this->wpanel->load_view('modulos/index', $content_vars);
    }

    /**
     * Mostra o formulário e cadastra um novo registro.
     * 
     * @return mixed
     */
    public function add()
    {
        $layout_vars = array();
        $content_vars = array();
        $this->form_validation->set_rules('name', 'Nome', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->wpanel->load_view('modulos/add', $content_vars);
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
            $data['created'] = date('Y-m-d H:i:s');
            $data['updated'] = date('Y-m-d H:i:s');
            $new_module = $this->module->save($data);
            if ($new_module)
            {
                $this->session->set_flashdata('msg_sistema', 'Registro salvo com sucesso.');
                redirect('admin/modulos/edit/' . $new_module);
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o registro.');
                redirect('admin/modulos');
            }
        }
    }

    /**
     * Mostra o formulário e altera um registro.
     * 
     * @param $id int Id do registro a ser editado.
     * @return mixed
     */
    public function edit($id = NULL)
    {
        $layout_vars = array();
        $content_vars = array();
        $this->form_validation->set_rules('name', 'Nome', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == NULL)
            {
                $this->session->set_flashdata('msg_sistema', 'Registro inexistente.');
                redirect('admin/modulos');
            }
            $query = $this->module->get_by_id($id)->row();
            $content_vars['actions_list'] = $this->actions_list($query->id);
            $content_vars['row'] = $query;
            $this->wpanel->load_view('modulos/edit', $content_vars);
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
            $data['updated'] = date('Y-m-d H:i:s');

            if ($this->module->update($id, $data))
            {
                $this->session->set_flashdata('msg_sistema', 'Registro salvo com sucesso.');
                redirect('admin/modulos');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o registro.');
                redirect('admin/modulos');
            }
        }
    }

    /**
     * Exclui um registro.
     * 
     * @param $id int Id do registro a ser excluído.
     * @return mixed
     */
    public function delete($id = null)
    {
        if ($id == null)
        {
            $this->session->set_flashdata('msg_sistema', 'Registro inexistente.');
            redirect('admin/modulos');
        }
        $this->module->delete_actions($id);
        if ($this->module->delete($id))
        {
            $this->session->set_flashdata('msg_sistema', 'Registro excluído com sucesso.');
            redirect('admin/modulos');
        } else
        {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o registro.');
            redirect('admin/modulos');
        }
    }

    private function actions_list($module_id = NULL)
    {
        $this->load->library('table');
        $layout_vars = array();
        $content_vars = array();
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('#', 'Descrição', 'Link', 'Lista branca', 'Ações');
        $query = $this->module_action->get_by_field('module_id', $module_id)->result();
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