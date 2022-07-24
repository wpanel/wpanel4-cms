<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Accounts class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Accounts extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('account', 'logaccess');
        $this->language_file = 'wpn_account_lang';
        parent::__construct();
    }

    /**
     * Index page.
     */
    public function index()
    {
        $this->load->library('table');
        $roles = config_item('auth_account_role');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(
                '#', wpn_lang('field_name'), wpn_lang('field_email'), wpn_lang('field_role'), wpn_lang('field_created_on'), wpn_lang('field_status'), wpn_lang('wpn_actions')
        );
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->account->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/accounts/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->account->limit($limit, $offset)
                            ->select('id, email, extra_data, role, created_on, status')
                            ->find_all();
        
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, json_decode($row->extra_data)->name, $row->email, $roles[$row->role], mdate(config_item('user_date_format'), strtotime($row->created_on)), status_post($row->status),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/accounts/access/' . $row->id, glyphicon('eye-open'), array('class' => 'btn btn-default')) .
                    anchor('admin/accounts/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/accounts/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                    div(null, true)
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Access log page.
     */
    public function access($account_id = NULL)
    {
        $this->load->library('table');
		$this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(
                wpn_lang('field_ip'), wpn_lang('field_access_data')
        );
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->logaccess->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/accounts/access/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->logaccess->limit($limit, $offset)
                            ->select('ip_address, created_on')
                            ->find_all();
        
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->ip_address, mdate('%d/%m/%Y %H:%i:%s', strtotime($row->created_on))
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Add new account.
     */
    public function add()
    {
        $this->form_validation->set_rules('password', wpn_lang('field_password'), 'required');
        $this->form_validation->set_rules('name', wpn_lang('field_name'), 'required');
        $this->form_validation->set_rules('email', wpn_lang('field_email'), 'required|valid_email|is_unique[accounts.email]');
        if ($this->form_validation->run() == FALSE)
        {
            $roles = config_item('auth_account_role');
            if(!$this->auth->is_root())
                unset($roles['ROOT']);
            $this->set_var('roles', $roles);
            $this->set_var('query_module', $this->list_modules_full());
            $this->render();
        } else
        {
            $result = $this->auth->register(
                $this->input->post('email'), $this->input->post('password'), $this->input->post('role'), array(
                    'name' => $this->input->post('name'),
                    'skin' => $this->input->post('skin'),
                    'avatar' => $this->wpanel->upload_media('avatar')
                ), $this->input->post('permission')
            );
            if ($result > 0)
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/accounts');
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/accounts');
        }
    }

    /**
     * Edit an account.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {

        $query = $this->account->find($id);
        $extra = (object) json_decode($query->extra_data);

        $this->form_validation->set_rules('name', wpn_lang('field_name'), 'required');
        $this->form_validation->set_rules('email', wpn_lang('field_email'), 'required|valid_email');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/accounts');
            $roles = config_item('auth_account_role');
            if(!$this->auth->is_root())
                unset($roles['ROOT']);
            $this->set_var('roles', $roles);
            $this->set_var('query_module', $this->list_modules_full());
            $this->set_var('row', $query);
            $this->set_var('extra', $extra);
            $this->render();
        } else
        {
            $extra->name = $this->input->post('name');
            $extra->skin = $this->input->post('skin');
            if ($this->input->post('change_avatar'))
                $extra->avatar = $this->wpanel->upload_media('avatar');
            else
                $extra->avatar = $this->input->post('avatar');
            $result = $this->auth->update(
                $id, $this->input->post('email'), $this->input->post('role'), $extra, $this->input->post('permission')
            );
            if ($result > 0){
                if($id == $this->auth->user_id())
                    $this->session->set_userdata('extra_data', $extra);
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/accounts');
            } else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/accounts');
        }
    }

    /**
     * Change an account password.
     * 
     * @param int $account_id
     */
    public function changepassword($account_id = NULL)
    {
        if ($account_id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/accounts');
        $result = $this->auth->change_password(
            $account_id, $this->input->post('password', TRUE)
        );
        if ($result > 0)
            $this->set_message(wpn_lang('message_password_change_success'), 'success', 'admin/accounts');
        else
            $this->set_message(wpn_lang('message_password_change_error'), 'danger', 'admin/accounts');
    }

    /**
     * Change an profile password.
     */
    public function changeprofilepassword()
    {
        $this->form_validation->set_rules('new_password', wpn_lang('field_new_password'), 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirmação de senha', 'required|matches[new_password]');
        $this->form_validation->set_rules('original_password', wpn_lang('field_original_password'), 'required');
        if ($this->form_validation->run()) {
            if ($this->auth->change_password(
                $this->auth->user_id(),
                $this->input->post('new_password', TRUE),
                $this->input->post('original_password', TRUE),
                true
            )) {
                redirect('admin/logout');
            }
            $this->set_message(wpn_lang('message_password_change_profile_error'), 'danger', 'admin/accounts/profile');
        }
        $this->set_message(wpn_lang('message_password_change_profile_error'), 'danger', 'admin/accounts/profile');
    }

    /**
     * Delete an account.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/accounts');
        if ($this->auth->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/accounts');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/accounts');
    }

    /**
     * Edit an account profile.
     */
    public function profile()
    {

        $query = $this->auth->account();
        $extra = (object) json_decode($query->extra_data);

        if ($this->input->post('alterar_senha') == '1')
            $this->form_validation->set_rules('password', wpn_lang('field_password'), 'required');
        $this->form_validation->set_rules('name', wpn_lang('field_name'), 'required');
        $this->form_validation->set_rules('email', wpn_lang('field_email'), 'required|valid_email');
        if ($this->form_validation->run() == FALSE)
        {
            if ($query->id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/dashboard');
            $this->set_var('row', $query);
            $this->set_var('extra', $extra);
            $this->render();
        } else
        {
            $extra->name = $this->input->post('name');
            $extra->skin = $this->input->post('skin');
            if ($this->input->post('change_avatar') == '1')
                $extra->avatar = $this->wpanel->upload_media('avatar');
            else
                $extra->avatar = $this->input->post('avatar');

            $result = $this->auth->update(
                $this->auth->user_id(), $this->input->post('email'), $query->role, $extra
            );
            if ($result > 0)
            {
                $this->session->set_userdata('extra_data', $extra);
                if ($this->input->post('change_password') == '1')
                    redirect('admin/logout');
                else
                    $this->set_message(wpn_lang('message_update_profile_success'), 'success', 'admin/accounts/profile');
            } else
                $this->set_message(wpn_lang('message_update_profile_error'), 'danger', 'admin/accounts/profile');
        }
    }

    /**
     * Activate an account.
     * 
     * @param int $account_id
     */
    public function activate($account_id = NULL)
    {
        if ($this->auth->activate($account_id))
            $this->set_message(wpn_lang('message_activate_success'), 'success', 'admin/accounts/edit/' . $account_id);
        else
            $this->set_message(wpn_lang('message_activate_error'), 'danger', 'admin/accounts/edit/' . $account_id);
    }

    /**
     * Deactivate an account.
     * 
     * @param int $account_id
     */
    public function deactivate($account_id = NULL)
    {
        if ($this->auth->deactivate($account_id))
            $this->set_message(wpn_lang('message_deactivate_success'), 'success', 'admin/accounts/edit/' . $account_id);
        else
            $this->set_message(wpn_lang('message_deactivate_error'), 'danger', 'admin/accounts/edit/' . $account_id);
    }

    /**
     * Return an modules list for permission settings.
     * 
     * @return mixed
     */
    private function list_modules_full()
    {
        $this->load->model(array('module', 'module_action'));
        $query_module = $this->module->order_by('order', 'asc')->as_array()->find_all();
        // Adiciona as actions na lista de módulos.
        foreach ($query_module as $key => $value)
        {
            $query_action = $this->module_action->where(array('whitelist' => '0', 'module_id' => $value['id']))->as_array()->find_all();
            $query_module[$key]['actions'] = $query_action;
        }
        return $query_module;
    }

}
