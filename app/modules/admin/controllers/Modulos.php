<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Modules itens class.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Modulos extends Authenticated_admin_controller
{

    /** @var Module */
    public $module;

    /** @var Module_action */
    public $module_action;

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('module', 'module_action');
        $this->language_file = 'wpn_module_lang';
        parent::__construct();
        // Somente root pode acessar este módulo especial.
        if (!$this->auth->is_root()) {
            $this->set_message(wpn_lang('wpn_message_no_module_permission'), 'danger', 'admin');
        }
    }

    /**
     * List of modules.
     *
     * @return mixed
     */
    public function index()
    {
        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_name'), wpn_lang('field_status'), wpn_lang('field_version'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->module->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/modulos/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->module->limit($limit, $offset)
                            ->select('id, name, status, system, version')
                            ->find_all();
        
        foreach ($query as $row) {
            $this->table->add_row(
                    $row->id, $row->name, status_label($row->status), $row->version,
                    // Ícones de ações
                    !$row->system || is_root() ? div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/modulos/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/modulos/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                    div(null, true) : glyphicon('lock')
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * New module.
     */
    public function add()
    {
        $this->form_validation->set_rules('name', 'Nome', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->render();
        } else {

            $data = array();
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['author_name'] = $this->input->post('author_name');
            $data['author_email'] = $this->input->post('author_email');
            $data['author_website'] = $this->input->post('author_website');
            $data['status'] = $this->input->post('status');
            $data['version'] = $this->input->post('version');
            $data['icon'] = ''; //TODO: Coming soon.
            $data['show_in_menu'] = '1'; //TODO: Coming soon.
            $data['order'] = 0;

            $new_module = $this->module->insert($data);
            if (!$new_module) {
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/modulos');
            }

            $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/modulos/edit/' . $new_module);

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

            if ($id == NULL) {
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'danger', 'admin/modulos');
            }

            $query = $this->module->find($id);
            $this->set_var('actions_list', $this->actions_list($query->id));
            $this->set_var('row', $query);

            $this->render();

        } else {

            $data = array();
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['author_name'] = $this->input->post('author_name');
            $data['author_email'] = $this->input->post('author_email');
            $data['author_website'] = $this->input->post('author_website');
            $data['status'] = $this->input->post('status');
            $data['version'] = $this->input->post('version');
            $data['icon'] = ''; //TODO: Coming soon.
            $data['show_in_menu'] = '1'; //TODO: Coming soon.
            $data['order'] = 0;

            if (!$this->module->update($id, $data)) {
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/modulos');
            }

            $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/modulos');

        }
    }

    /**
     * Delete an module.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null) {
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'danger', 'admin/modulos');
        }

        if ($this->module->delete($id)) {
            $this->module_action->delete_by('module_id', $id);
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/modulos');
        }

        $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/modulos');

    }

    /**
     * Add module actions.
     *
     * @param int $module_id
     */
    public function addaction($module_id = NULL)
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
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/modulos/edit/' . $module_id);
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/modulos/edit/' . $module_id);
        }
    }

    /**
     * Edit a module action.
     *
     * @param int $id
     * @param int $module_id
     */
    public function altaction($id = NULL, $module_id = NULL)
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
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/modulos/edit/' . $module_id);
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/modulos/edit/' . $module_id);
        }
    }

    /**
     * Delete a module action.
     *
     * @param int $id
     * @param int $module_id
     */
    public function deleteaction($id = NULL, $module_id = NULL)
    {
        if ($id == null)
            $this->set_message('Registro inexistente.', 'danger', 'admin/modulos');

        if ($this->module_action->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/modulos/edit/' . $module_id);
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/modulos/edit/' . $module_id);
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
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_description'), wpn_lang('field_link'), wpn_lang('field_whitelist'), wpn_lang('wpn_actions'));
        $query = $this->module_action->find_many_by('module_id', $module_id);
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->description, $row->link, sim_nao($row->whitelist),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/modulos/altaction/' . $row->id . '/' . $row->module_id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/modulos/deleteaction/' . $row->id . '/' . $row->module_id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                    div(null, true)
            );
        }
        return $this->table->generate();
    }

}

// End of file modules/admin/controllers/Modulos.php
