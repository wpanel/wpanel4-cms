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
class Accounts extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'account';
        parent::__construct();
    }

    /**
     * Index page.
     */
    public function index()
    {
        $this->load->library('table');
        $roles = config_item('users_role');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading(
                '#', 'Nome', 'E-mail', 'Role', wpn_lang('col_date', 'Date'), wpn_lang('col_status', 'Status'), wpn_lang('col_actions', 'Actions')
        );
        $query = $this->account->find_all();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, json_decode($row->extra_data)->name, $row->email, $row->role, mdate('%d/%m/%Y', strtotime($row->created_on)), status_post($row->status),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/accounts/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/accounts/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Add new account.
     */
    public function add()
    {
        $this->form_validation->set_rules('password', 'Senha', 'required');
        $this->form_validation->set_rules('name', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[accounts.email]');
        if ($this->form_validation->run() == FALSE)
        {
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
                $this->set_message('Usuário salvo com sucesso!', 'success', 'admin/accounts');
            else
                $this->set_message('Erro ao salvar o usuário.', 'danger', 'admin/accounts');
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

        $this->form_validation->set_rules('name', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Usuário inexistende.', 'info', 'admin/accounts');
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
            if ($result > 0)
                $this->set_message('Usuário salvo com sucesso!', 'success', 'admin/accounts');
            else
                $this->set_message('Erro ao salvar o usuário.', 'danger', 'admin/accounts');
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
            $this->set_message('Usuário inexistende.', 'info', 'admin/accounts');
        $result = $this->auth->change_password(
                $account_id, $this->input->post('password', TRUE)
        );
        if ($result > 0)
            $this->set_message('Senha alterada com sucesso!', 'success', 'admin/accounts');
        else
            $this->set_message('Erro ao alterar a senha.', 'danger', 'admin/accounts');
    }

    /**
     * Change an profile password.
     */
    public function changeprofilepassword()
    {
        $result = $this->auth->change_password(
                $this->auth->user_id(), $this->input->post('password', TRUE)
        );
        if ($result > 0)
            redirect ('admin/logout');
        else
            $this->set_message('Erro ao alterar a senha.', 'danger', 'admin/accounts/profile');
    }

    /**
     * Delete an account.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message('Usuário inexistende.', 'info', 'admin/accounts');
        if ($this->auth->delete($id))
            $this->set_message('Usuário excluído com sucesso!', 'success', 'admin/accounts');
        else
            $this->set_message('Erro ao excluir o usuário.', 'danger', 'admin/accounts');
    }

    /**
     * Edit an account profile.
     */
    public function profile()
    {

        $query = $this->auth->account();
        $extra = (object) json_decode($query->extra_data);

        if ($this->input->post('alterar_senha') == '1')
            $this->form_validation->set_rules('password', 'Senha', 'required');
        $this->form_validation->set_rules('name', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE)
        {
            if ($query->id == null)
                $this->set_message('Usuário inexistende.', 'info', 'admin/dashboard');
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
                if ($this->input->post('change_password') == '1')
                    redirect('admin/logout');
                else
                    $this->set_message('Seus dados foram alterados com sucesso!', 'success', 'admin/accounts/profile');
            } else
                $this->set_message('Erro ao alterar os seus dados.', 'danger', 'admin/accounts/profile');
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
            $this->set_message('Conta ativada com sucesso!', 'success', 'admin/accounts/edit/' . $account_id);
        else
            $this->set_message('Não foi possível ativar a conta.', 'danger', 'admin/accounts/edit/' . $account_id);
    }

    /**
     * Deactivate an account.
     * 
     * @param int $account_id
     */
    public function deactivate($account_id = NULL)
    {
        if ($this->auth->deactivate($account_id))
            $this->set_message('Conta desativada com sucesso!', 'success', 'admin/accounts/edit/' . $account_id);
        else
            $this->set_message('Não foi possível desativar a conta.', 'danger', 'admin/accounts/edit/' . $account_id);
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
