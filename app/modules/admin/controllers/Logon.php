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
        $this->language_file = 'wpn_logon_lang';
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

        $this->form_validation->set_rules('email', wpn_lang('input_email'), 'required|valid_email');
        $this->form_validation->set_rules('password', wpn_lang('input_password'), 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->set_var('title', 'Login');
            $this->layout('logon')->render();
        } else {
            if ($this->auth->login($this->input->post('email'), $this->input->post('password'))) {
                return redirect('admin');
            } else {
                $this->session->set_flashdata('msg_auth', wpn_lang('logon_login_error'));
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
        $this->set_var('title', 'Password recovery');
        $this->form_validation->set_rules('email', wpn_lang('logon_email'), 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            if ($token) {
                if ($this->auth->recovery($token)) {
                    $this->layout('logon')->view('logon/recovery_done')->render();
                } else {
                    $this->session->set_flashdata('msg_recover', wpn_lang('logon_recovery_invalid_link'));
                    redirect('admin/recovery');
                }
            } else {
                $this->layout('logon')->render();
            }
        } else {
            $email = $this->input->post('email');
            if ($this->auth->email_exists($email) == FALSE) {
                $this->session->set_flashdata('msg_recover', wpn_lang('logon_recovery_invalid_email'));
                redirect('admin/recovery');
            }

            if ($this->auth->send_recovery($email)) {
                $this->session->set_flashdata('msg_auth', wpn_lang('logon_recovery_success'));
                redirect('admin/login');
            } else {
                $this->session->set_flashdata('msg_recover', wpn_lang('logon_recovery_error'));
                redirect('admin/recovery');
            }
        }
    }

}
