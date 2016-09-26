<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
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
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->load->model('account');
        $this->auth->check_permission();
    }

    public function index()
    {
        $layout_vars = array();
        $content_vars = array();
        $this->load->library('table');
        $roles = config_item('users_role');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading(
                '#', 
                'Nome', 
                'E-mail', 
                'Role', 
                wpn_lang('col_date', 'Date'), 
                wpn_lang('col_status', 'Status'), 
                wpn_lang('col_actions', 'Actions')
        );
        $query = $this->auth->list_accounts();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, 
                    $this->auth->get_extra_data('name', $row->extra_data), 
                    $row->email, 
                    $row->role, 
                    mdate('%d/%m/%Y', strtotime($row->created)), 
                    status_post($row->status),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/accounts/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/accounts/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $content_vars['listagem'] = $this->table->generate();
        $this->wpanel->load_view('accounts/index', $content_vars);
    }

    public function add()
    {
        $this->form_validation->set_rules('password', 'Senha', 'required');
        $this->form_validation->set_rules('name', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[accounts.email]');
        if ($this->form_validation->run() == FALSE){
            $content_vars = array();
            $content_vars['query_module'] = $this->auth->list_modules_full();
            $this->wpanel->load_view('accounts/add', $content_vars);
        } else {

            // Cria a nova conta.
            $newaccount = $this->auth->create_account(
                $this->input->post('email'), 
                $this->input->post('password'), 
                $this->input->post('role'), 
                array(
                    'name' => $this->input->post('name'),
                    'skin' => $this->input->post('skin'),
                    'avatar' => $this->auth->upload_avatar()
                ),
                $this->input->post('permission')
            );

            if ($newaccount > 0) {
                $this->session->set_flashdata('msg_sistema', 'Usuário salvo com sucesso.');
                redirect('admin/accounts');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
                redirect('admin/accounts');
            }
        }
    }

    public function edit($id = null)
    {

        $this->form_validation->set_rules('name', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {

            if ($id == null) {
                $this->session->set_flashdata('msg_sistema', 'Usuário inexistente.');
                redirect('admin/usuarios');
            }

            $content_vars = array();

            $content_vars['query_module'] = $this->auth->list_modules_full();
            $content_vars['row'] = $this->auth->get_account_by_id($id);
            $this->wpanel->load_view('accounts/edit', $content_vars);

        } else {

            $extra_data = array();
            $extra_data['name'] = $this->input->post('name');
            $extra_data['skin'] = $this->input->post('skin');
            if($this->input->post('change_avatar'))
                $extra_data['avatar'] = $this->auth->upload_avatar();
            else
                $extra_data['avatar'] = $this->input->post('avatar');

            // Atualiza uma conta.
            $updatedaccount = $this->auth->update_account(
                $id,
                $this->input->post('email'),
                $this->input->post('role'),
                $extra_data,
                $this->input->post('permission')
            );

            if ($updatedaccount > 0) {
                $this->session->set_flashdata('msg_sistema', 'Usuário salvo com sucesso.');
                redirect('admin/accounts');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o usuário.');
                redirect('admin/accounts');
            }
        }
    }

    public function changepassword($account_id = NULL)
    {
        if($account_id == NULL){
            $this->session->set_flashdata('msg_sistema', 'Não foi possível alterar a senha.');
            redirect('admin/accounts');
        }

        $updatedpassword = $this->auth->change_password(
            $account_id,
            NULL,
            $this->input->post('password', TRUE)
        );

        if ($updatedpassword > 0) {
            $this->session->set_flashdata('msg_sistema', 'Senha alterada com sucesso.');
            redirect('admin/accounts/edit/'.$account_id);
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao alterar a senha.');
            redirect('admin/accounts/edit/'.$account_id);
        }
    }

    public function delete($id = null)
    {

        if ($id == null) {
            $this->session->set_flashdata('msg_sistema', 'Conta de usuário inexistente.');
            redirect('admin/accounts');
        }

        if ($this->auth->remove_account($id)) {
            $this->session->set_flashdata('msg_sistema', 'Conta de usuário excluída com sucesso.');
            redirect('admin/accounts');
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir a conta de usuário.');
            redirect('admin/accounts');
        }
    }

    public function profile()
    {
        // Verifica se altera a senha
        if ($this->input->post('alterar_senha') == '1')
            $this->form_validation->set_rules('password', 'Senha', 'required');

        $this->form_validation->set_rules('name', 'Nome completo', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $content_vars = array();
            $account_data = $this->auth->get_account_by_id($this->auth->get_account_id());
            if ($account_data->id == null) {
                $this->session->set_flashdata('msg_sistema', 'Usuário inexistente.');
                redirect('admin/dashboard');
            }
            $content_vars['row'] = $account_data;
            $content_vars['extra_data'] = $this->auth->get_extra_data(NULL, $account_data->extra_data);
            $this->wpanel->load_view('accounts/profile', $content_vars);
        } else {
            $extra_data = array();
            $extra_data['name'] = $this->input->post('name');
            $extra_data['skin'] = $this->input->post('skin');
            if($this->input->post('change_avatar') == '1')
                $extra_data['avatar'] = $this->auth->upload_avatar();
            else
                $extra_data['avatar'] = $this->input->post('avatar');

            $updatedaccount = $this->auth->update_account(
                $this->auth->get_account_id(),
                $this->input->post('email'),
                $this->input->post('role'),
                $extra_data
            );

            if ($updatedaccount > 0) {
                if ($this->input->post('change_password') == '1') {
                    redirect('admin/logout');
                } else {
                    $this->session->set_flashdata('msg_sistema', 'Seus dados foram salvos com sucesso.');
                    redirect('admin/accounts/profile');
                }
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar os seus dados.');
                redirect('admin/accounts/profile');
            }
        }
    }

}
