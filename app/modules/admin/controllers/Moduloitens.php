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
 * Modules class.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
 */
class Moduloitens extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = "module_action";
        parent::__construct();
        // Somente root pode acessar este módulo especial.
        if (!$this->auth->is_root())
            $this->set_message('Você não tem permissão para acessar este módulo.', 'danger', 'admin');
    }

    /**
     * List of modules.
     */
    public function index()
    {
        redirect('admin/modulos');
    }

    /**
     * Insert an module.
     */
    public function add($module_id = NULL)
    {
        $this->form_validation->set_rules('description', 'Descrição', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->set_var('module_id', $module_id);
            $this->render();
        } else
        {
            $data = array();
            $data['module_id'] = $module_id;
            $data['description'] = $this->input->post('description');
            $data['link'] = $this->input->post('link');
            if ($this->input->post('whitelist') == '1')
                $data['whitelist'] = '1';
            else
                $data['whitelist'] = '0';

            if ($this->module_action->insert($data))
                $this->set_message('Registro salvo com sucesso.', 'success', 'admin/modulos/edit/' . $module_id);
            else
                $this->set_message('Erro ao salvar o registro.', 'danger', 'admin/modulos/edit/' . $module_id);
        }
    }

    /**
     * Edit an module.
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id = NULL, $module_id = NULL)
    {
        $this->form_validation->set_rules('description', 'Descrição', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');
        if ($this->form_validation->run() == FALSE)
        {

            if ($id == NULL)
                $this->set_message('Registro inexistente.', 'danger', 'admin/modulos');

            $this->set_var('module_id', $module_id);
            $this->set_var('row', $this->module_action->find($id));

            $this->render();
        } else
        {

            $data = array();
            $data['module_id'] = $module_id;
            $data['description'] = $this->input->post('description');
            $data['link'] = $this->input->post('link');
            if ($this->input->post('whitelist') == '1')
                $data['whitelist'] = '1';
            else
                $data['whitelist'] = '0';

            if ($this->module_action->update($id, $data))
                $this->set_message('Registro salvo com sucesso.', 'success', 'admin/modulos/edit/' . $module_id);
            else
                $this->set_message('Erro ao salvar o registro.', 'danger', 'admin/modulos/edit/' . $module_id);
        }
    }

    /**
     * Delete an module.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id = NULL, $module_id = NULL)
    {
        if ($id == null)
            $this->set_message('Registro inexistente.', 'danger', 'admin/modulos');

        if ($this->module_action->delete($id))
            $this->set_message('Registro excluído com sucesso.', 'success', 'admin/modulos/edit/' . $module_id);
        else
            $this->set_message('Erro ao excluir o registro.', 'danger', 'admin/modulos/edit/' . $module_id);
    }

}

// End of file modules/admin/controllers/Moduloitens.php
