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
 * FITNESS FOR  A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
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
 * This class executes the authentication functions into the Wpanel CMS.
 *
 * @package Wpanel
 * @author Eliel de Paula <dev@gelieldepaula.com.br>
 * @since v1.0.0
 */
class Logon extends MY_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Index page of logon.
     * @return void
     */
    public function index()
    {

        if ($this->auth->accounts_empty() == TRUE)
            redirect('setup');

        $this->form_validation->set_rules('email', wpn_lang('input_email', 'Email'), 'required|valid_email');
        $this->form_validation->set_rules('password', wpn_lang('input_password', 'Password'), 'required');

        if ($this->form_validation->run() == FALSE)
            $this->load->view('logon/index');
        else
        {
            if ($this->auth->login($this->input->post('email'), $this->input->post('password')))
            {
                return redirect('admin');
            } else
            {
                $this->session->set_flashdata('msg_auth', wpn_lang('msg_login_error', 'Your login failed, try again.'));
                return redirect('admin/login');
            }
        }
    }

    /**
     * This method does the logout of the user account.
     *
     * @return void
     */
    public function out()
    {
        $this->auth->logout();
        redirect('admin/login');
    }

    /**
     * Password recovery method.
     * 
     * @param string $token
     */
    public function recovery($token = NULL)
    {
        $this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email');
        if ($this->form_validation->run() == FALSE)
        {
            if ($token)
            {
                if ($this->auth->recovery($token))
                    $this->view('users/recovery_done')->render();
                else
                {
                    $this->session->set_flashdata('msg_recover', 'Link de confirmação inválido.');
                    redirect('admin/recovery');
                }
            } else
                $this->load->view('logon/recovery');
        } else
        {
            $email = $this->input->post('email');
            if ($this->auth->email_exists($email) == FALSE)
            {
                $this->session->set_flashdata('msg_recover', 'O e-mail informado não existe em nosso cadastro.');
                redirect('admin/recovery');
            }

            if ($this->auth->send_recovery($email))
            {
                $this->session->set_flashdata('msg_auth', 'Enviamos uma mensagem para o e-mail informado com um link para confirmar sua solicitação de recuperação de senha.');
                redirect('admin/login');
            } else
            {
                $this->session->set_flashdata('msg_recover', 'Houve um erro inesperado e sua senha não pode ser redefinida. Tente novamente mais tarde.');
                redirect('admin/recovery');
            }
        }
    }

}
