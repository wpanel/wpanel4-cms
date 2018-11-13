<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

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
     * Constructor da classe.
     */
    function __construct()
    {

        /**
         * ---------------------------------------------------------------------
         * Aqui ficam disponíveis algumas opções disponibilizadas pela classe
         * MY_Controller que você pode ajustar de acordo com seu projeto.
         * ---------------------------------------------------------------------
         */
        
        /**
         * Ativa o profiler (Forensics).
         */
        $this->show_profiler = FALSE;

        parent::__construct();

        if ($this->auth->is_logged() and $this->auth->is_admin())
        {
            $this->set_message('Esta área é destinada somente a usuários comuns.', 'info', '');
            $this->auth->logout();
        }
    }

    /**
     * Dashboard do usuário.
     */
    public function index()
    {
        // Check the login.
        if (!$this->auth->is_logged())
            redirect('users/login');
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
        if ($this->form_validation->run() == FALSE)
        {
            $this->wpanel->set_meta_title('Cadastro de usuários');
            $this->render();
        } else
        {
            try {
                $extra_data = array(
                    'name' => $this->input->post('name'),
                    'avatar' => '',
                    'skin' => ''
                );
                if ($this->auth->register($this->input->post('email'), $this->input->post('password'), 'user', $extra_data))
                    redirect('users/registerok');
                else
                    $this->set_message('Sua conta não pode ser criada, verifique seus dados e tente novamente.', 'danger', 'users/register');
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
        try
        {
            $this->auth->activate_token_account($token);
            $this->wpanel->set_meta_title('Ativação de usuários');
            $this->render();
        } catch (Exception $e)
        {
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
        if ($this->form_validation->run() == FALSE)
        {

            if ($token)
            {
                if ($this->auth->recovery($token))
                    $this->view('users/recovery_done')->render();
                else
                    $this->set_message('Link de confirmação inválido.', 'danger', 'users/recovery');
            } else
                $this->view('users/recovery_form')->render();
        } else
        {

            $email = $this->input->post('email');
            if ($this->auth->email_exists($email) == FALSE)
                $this->set_message('O e-mail informado não existe em nosso cadastro.', 'danger', 'users/recovery');

            if ($this->auth->send_recovery($email))
                $this->view('users/recovery_sent')->render();
            else
                $this->set_message('Houve um erro inesperado e sua senha não pode ser redefinida. Tente novamente mais tarde.', 'danger', 'users/recovery');
        }
    }

    /**
     * Perfil do usuário.
     */
    public function profile()
    {
        // Verifica o login.
        if (!$this->auth->is_logged())
            redirect('users/login');

        // Recupera os dados do usuário.
        $query = $this->auth->account();
        $profile = $this->auth->profile();

        $this->form_validation->set_rules('name', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email');
        if ($this->input->post('alt_password'))
            $this->form_validation->set_rules('password', 'Senha', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->wpanel->set_meta_title('Área de usuários');
            $this->set_var('account', $query);
            $this->set_var('profile', $profile);
            $this->render();
        } else
        {
            // Salva os dados adicionais na coluna 'extra_data' na tabela accounts.
            $profile->name = $this->input->post('name');
            /*
             * Aqui você pode definir novos campos de dados extra para ser
             * salvo no campo extra_data na tabela accounts.
             */

            try {
                if ($this->auth->update($query->id, $this->input->post('email'), 'user', $profile))
                {
                    if ($this->input->post('alt_password'))
                        $this->auth->change_password($query->id, $this->input->post('password'));
                    $this->set_message('Seus dados foram alterados com sucesso.', 'success', 'users/profile');
                } else
                    $this->set_message('Houve um erro inesperado e seus dados não puderam ser alterados. Tente novamente mais tarde.', 'danger', 'users/profile');
            } catch (Exception $ex) {
                $this->set_message('Ocorreu um erro: ' . $ex->getMessage(), 'danger', 'users/profile');
            }
            
        }
    }

    /**
     * Página de login de usuários.
     */
    public function login()
    {
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Senha', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->wpanel->set_meta_title('Login de usuários');
            $this->render();
        } else
        {
            if ($this->auth->login($this->input->post('email'), $this->input->post('password')))
                return redirect('users');
            else
                $this->set_message('Seu login falhou, tente novamente.', 'danger', 'users/login');
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
