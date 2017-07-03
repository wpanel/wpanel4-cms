<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class executes the authentication functions into the Wpanel CMS.
 *
 * @author Eliel de Paula <dev@gelieldepaula.com.br>
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
