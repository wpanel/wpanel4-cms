<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modules class.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
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
