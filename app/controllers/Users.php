<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.com/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

class Users extends MY_Controller
{
    /** @var Wpanel */
    public $wpanel;
    /** @var Auth */
    public $auth;

    /**
     * Class constructor.
     */
    function __construct()
    {

        /**
         * Load the language file.
         */
        $this->language_file = ['theme_default_lang', 'controller_users_lang'];

        parent::__construct();

        /**
         * Set the template.
         */
        $this->template('default');

        if ($this->auth->is_logged() && $this->auth->is_admin()) {
            $this->set_message(wpn_lang('message_common_login_only'), 'info', '');
            $this->auth->logout();
        }
    }

    /**
     * Users account dashboard.
     *
     * @return void
     */
    public function index()
    {
        if (!$this->auth->is_logged()) {
            redirect('users/login');
        }
        $this->wpanel->set_meta_title(wpn_lang('users_dashboard_title'));
        $this->render();
    }

    /**
     * New user account registration.
     *
     * @return void
     */
    public function register()
    {
        $this->form_validation->set_rules('name', wpn_lang('input_name'), 'required');
        $this->form_validation->set_rules('email', wpn_lang('input_email'), 'required|valid_email');
        $this->form_validation->set_rules('password', wpn_lang('input_password'), 'required');
        $this->form_validation->set_rules('confpass', wpn_lang('input_password_confirmation'), 'required|matches[password]');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_title(wpn_lang('users_registration_title'));
            $this->render();
        } else {
            try {
                $extra_data = array(
                    'name' => $this->input->post('name'),
                    'avatar' => '',
                    'skin' => ''
                );
                if (!$this->auth->register($this->input->post('email'), $this->input->post('password'), 'user', $extra_data)) {
                    $this->set_message(wpn_lang('message_users_registration_error'), 'danger', 'users/register');
                }
                redirect('users/registerok');
            } catch (Exception $ex) {
                $this->set_message(wpn_lang('message_users_registration_exception') . $ex->getMessage(), 'danger', 'users/register');
            }
        }
    }

    /**
     * User account registration success message.
     *
     * @return void
     */
    public function registerok()
    {
        $this->wpanel->set_meta_title(wpn_lang('users_registration'));
        $this->render();
    }

    /**
     * Activation of user accounts by token.
     *
     * @param $token string
     * @return void
     */
    public function activate($token)
    {
        try {
            $this->auth->activate_token_account($token);
            $this->wpanel->set_meta_title(wpn_lang(('users_activation_title')));
            $this->render();
        } catch (Exception $e) {
            $this->set_message(wpn_lang('message_users_activation_exception') . $e->getMessage(), 'danger', 'users');
        }
    }

    /**
     * This method does the password recovery of user accounts.
     *
     * @param $token string
     * @return void
     */
    public function recovery($token = NULL)
    {
        $this->form_validation->set_rules('email', wpn_lang('input_email'), 'required|valid_email');
        if (!$this->form_validation->run()) {
            if ($token) {
                if (!$this->auth->recovery($token)) {
                    $this->set_message(wpn_lang('message_recovery_link_error'), 'danger', 'users/recovery');
                }
                $this->view('users/recovery_done')->render();
            }
            $this->view('users/recovery_form')->render();
        } else {
            $email = $this->input->post('email');
            if (!$this->auth->email_exists($email)) {
                $this->set_message(wpn_lang('message_users_invalid_email'), 'danger', 'users/recovery');
            }
            if (!$this->auth->send_recovery($email)) {
                $this->set_message(wpn_lang('message_users_recovery_fail'), 'danger', 'users/recovery');
            }
            $this->view('users/recovery_sent')->render();
        }
    }

    /**
     * User account profile.
     *
     * @return void
     */
    public function profile()
    {
        if (!$this->auth->is_logged()) {
            redirect('users/login');
        }
        $query = $this->auth->account();
        $profile = $this->auth->profile();
        $this->form_validation->set_rules('name', wpn_lang('input_name'), 'required');
        $this->form_validation->set_rules('email', wpn_lang('input_email'), 'required|valid_email');
        if ($this->input->post('alt_password')) {
            $this->form_validation->set_rules('new_password', wpn_lang('input_password'), 'required');
            $this->form_validation->set_rules('confirm_password', wpn_lang('input_password_confirmation'), 'required|matches[new_password]');
        }
        if ($this->form_validation->run()) {
            $profile->name = $this->input->post('name');
            /**
             * Here you can define new data fields to be saved in the
             * extra_data field in the accounts table.
             */
            try {
                if ($this->auth->update($query->id, $this->input->post('email'), 'user', $profile)) {
                    if ($this->input->post('alt_password')) {
                        $this->auth->change_password(
                            $query->id,
                            $this->input->post('new_password', true),
                            $this->input->post('original_password', true),
                        true
                        );
                    }
                    $this->set_message(wpn_lang('message_users_update_success'), 'success', 'users/profile');
                }
                $this->set_message(wpn_lang('message_users_update_fail'), 'danger', 'users/profile');
            } catch (Exception $ex) {
                $this->set_message(wpn_lang('message_users_update_exception') . $ex->getMessage(), 'danger', 'users/profile');
            }
        }
        $this->wpanel->set_meta_title(wpn_lang('users_dashboard_title'));
        $this->set_var('account', $query);
        $this->set_var('profile', $profile);
        $this->render();
    }

    /**
     * User account login.
     *
     * @return void
     */
    public function login()
    {
        $this->form_validation->set_rules('email', wpn_lang('input_email'), 'required|valid_email');
        $this->form_validation->set_rules('password', wpn_lang('input_password'), 'required');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_title(wpn_lang('users_login_title'));
            $this->render();
        } else {
            if (!$this->auth->login($this->input->post('email'), $this->input->post('password'))) {
                $this->set_message(wpn_lang('message_users_login_fail'), 'danger', 'users/login');
            }
            $this->set_message(wpn_lang('message_users_login_welcome'), 'success', 'users');
        }
    }

    /**
     * User logout.
     *
     * @return void
     */
    public function logout()
    {
        $this->auth->logout();
        redirect();
    }

}
