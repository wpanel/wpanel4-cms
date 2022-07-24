<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.com/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Classe Users
 *
 * Esta classe contém os métodos básicos para gerenciamento de usuários
 * no site.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Users extends MY_Controller
{
    /**
     * @var Wpanel
     */
    public $wpanel;
    /**
     * @var Auth
     */
    public $auth;

    /**
     * Constructor da classe.
     */
    function __construct()
    {

        parent::__construct();

        /**
         * Define o template.
         */
        $this->template('default');

        if ($this->auth->is_logged() && $this->auth->is_admin()) {
            $this->set_message('Esta área é destinada somente a usuários comuns.', 'info', '');
            $this->auth->logout();
        }
    }

    /**
     * Dashboard do usuário.
     */
    public function index()
    {
        if (!$this->auth->is_logged()) {
            redirect('users/login');
        }
        $this->wpanel->set_meta_title('Área de usuários');
        $this->render();
    }

    /**
     * Registro de novos usuários.
     */
    public function register()
    {
        $this->form_validation->set_rules('name', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Senha', 'required');
        $this->form_validation->set_rules('confpass', 'Confirmação de senha', 'required|matches[password]');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_title('Cadastro de usuários');
            $this->render();
        } else {
            try {
                $extra_data = array(
                    'name' => $this->input->post('name'),
                    'avatar' => '',
                    'skin' => ''
                );
                if (!$this->auth->register($this->input->post('email'), $this->input->post('password'), 'user', $extra_data)) {
                    $this->set_message('Sua conta não pode ser criada, verifique seus dados e tente novamente.', 'danger', 'users/register');
                }
                redirect('users/registerok');
            } catch (Exception $ex) {
                $this->set_message('Ocorreu um erro: ' . $ex->getMessage(), 'danger', 'users/register');
            }
        }
    }

    /**
     * Mensagem de sucesso no registro do usuário.
     */
    public function registerok()
    {
        $this->wpanel->set_meta_title('Cadastro de usuários');
        $this->render();
    }

    /**
     * Método para ativação de contas de usuário pelo Token.
     *
     * @param string $token
     */
    public function activate($token)
    {
        try {
            $this->auth->activate_token_account($token);
            $this->wpanel->set_meta_title('Ativação de usuários');
            $this->render();
        } catch (Exception $e) {
            $this->set_message('Sua conta não pode ser ativada, verifique seus dados e tente novamente. Erro: ' . $e->getMessage(), 'danger', 'users');
        }
    }

    /**
     * Recuperação de senhas de contas de usuário.
     *
     * @param string $token
     */
    public function recovery($token = NULL)
    {
        $this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email');
        if (!$this->form_validation->run()) {
            if ($token) {
                if (!$this->auth->recovery($token)) {
                    $this->set_message('Link de confirmação inválido.', 'danger', 'users/recovery');
                }
                $this->view('users/recovery_done')->render();
            }
            $this->view('users/recovery_form')->render();
        } else {
            $email = $this->input->post('email');
            if (!$this->auth->email_exists($email)) {
                $this->set_message('O e-mail informado não existe em nosso cadastro.', 'danger', 'users/recovery');
            }
            if (!$this->auth->send_recovery($email)) {
                $this->set_message('Houve um erro inesperado e sua senha não pode ser redefinida. Tente novamente mais tarde.', 'danger', 'users/recovery');
            }
            $this->view('users/recovery_sent')->render();
        }
    }

    /**
     * Perfil do usuário.
     */
    public function profile()
    {
        if (!$this->auth->is_logged()) {
            redirect('users/login');
        }
        $query = $this->auth->account();
        $profile = $this->auth->profile();
        $this->form_validation->set_rules('name', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email');
        if ($this->input->post('alt_password')) {
            $this->form_validation->set_rules('new_password', 'Senha', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirmação de senha', 'required|matches[new_password]');
        }
        if ($this->form_validation->run()) {
            $profile->name = $this->input->post('name');
            /*
             * Aqui você pode definir novos campos de dados extra para ser
             * salvo no campo extra_data na tabela accounts.
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
                    $this->set_message('Seus dados foram alterados com sucesso.', 'success', 'users/profile');
                }
                $this->set_message('Houve um erro inesperado e seus dados não puderam ser alterados. Tente novamente mais tarde.', 'danger', 'users/profile');
            } catch (Exception $ex) {
                $this->set_message('Ocorreu um erro: ' . $ex->getMessage(), 'danger', 'users/profile');
            }
        }
        $this->wpanel->set_meta_title('Área de usuários');
        $this->set_var('account', $query);
        $this->set_var('profile', $profile);
        $this->render();
    }

    /**
     * Página de login de usuários.
     */
    public function login()
    {
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Senha', 'required');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_title('Login de usuários');
            $this->render();
        } else {
            if (!$this->auth->login($this->input->post('email'), $this->input->post('password'))) {
                $this->set_message('Seu login falhou, tente novamente.', 'danger', 'users/login');
            }
            $this->set_message('Bem vindo!', 'success', 'users');
        }
    }

    /**
     * Loogut de usuários.
     */
    public function logout()
    {
        $this->auth->logout();
        redirect();
    }

}
