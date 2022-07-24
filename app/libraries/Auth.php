<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is the auth library. It contains the methods that manage the users accounts
 * and his acces into the website.
 * 
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 */
class Auth
{

    /**
     * Check permissions by hook.
     * @var boolean 
     */
    protected $auth_check_permyssion_by_hook = FALSE;

    /**
     * Set password hash type.
     * @var string 
     */
    protected $auth_password_hash_type = 'md5';

    /**
     * Set password salt string.
     * @var string 
     */
    protected $auth_password_hash_salt;

    /**
     * Set an white-list for URI
     * @var mixed 
     */
    protected $auth_white_list = array();

    public function __construct($config = array())
    {
        if (@count($config) > 0)
            $this->initialize($config);

        $this->load->model(array('account', 'permission', 'ipban', 'ipallowed', 'logaccess', 'ipattempt', 'module_action'));

        log_message('debug', "Auth Class Initialized");
    }

    /**
     * Get the instance of CI.
     *
     * @return mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    /**
     * Initialize the library loading the configuration files or
     * an array() passed on load of the class.
     *
     * @param $config array()
     * @return void
     */
    public function initialize($config = array())
    {
        foreach ($config as $key => $val)
        {
            if (isset($this->$key))
            {
                $method = 'set_' . $key;
                if (method_exists($this, $method))
                    $this->$method($val);
                else
                    $this->$key = $val;
            }
        }
        return $this;
    }

    /**
     * Register a new user account.
     * 
     * @param string $email
     * @param string $password
     * @param string $role
     * @param array $extra_data
     * @param array $permissions
     * @param string $token
     * @param string $token_by
     * @return mixed
     * @throws Exception
     */
    public function register($email, $password, $role, $extra_data = array(), $permissions = array(), $token = null, $token_by = null)
    {

        if ($this->email_exists($email))
            throw new Exception("E-mail já cadastrado");

        $data = array();
        $data['email'] = $email;
        $data['password'] = $this->_hash_password($password);
        $data['token'] = $token == null ? $this->_generate_token() : $token;
        $data['token_by'] = $token_by == null ? 'System' : $token_by;
        $data['role'] = $role;
        $data['extra_data'] = json_encode($extra_data);
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['status'] = 0;
        $result = $this->account->insert($data);

        if (@count($permissions) > 0 and $result > 0)
        {
            foreach ($permissions as $key => $value)
            {
                $this->_create_permission($value, $result);
            }
        }
        $data_message = array(
            'email' => $email,
            'token' => $data['token']
        );
        $data_email = array(
            'html' => TRUE,
            'from_name' => wpn_config('site_titulo'),
            'from_email' => wpn_config('site_contato'),
            'to' => $email,
            'subject' => 'Ativação de cadastro.',
            'message' => $this->load->view('emails/account_activation', $data_message, TRUE),
        );
        if ($role != 'ROOT')
            $this->wpanel->send_email($data_email);

        if (!$result > 0)
            throw new Exception('Erro fatal criando nova conta');

        return $result;
    }

    /**
     * Update an user account.
     *
     * @param int $account_id
     * @param string $email
     * @param string $role
     * @param mixed $extra_data
     * @param array $permissions
     * @return mixed
     * @throws Exception
     */
    public function update($account_id, $email, $role, $extra_data = array(), $permissions = array())
    {
        $data = array();
        $data['email'] = $email;
        $data['role'] = $role;
        if (!empty($extra_data))
            $data['extra_data'] = json_encode($extra_data);
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];

        $result = $this->account->update($account_id, $data);

        if (@count($permissions) > 0)
        {
            $this->_remove_permission($account_id);
            foreach ($permissions as $key => $value)
            {
                $this->_create_permission($value, $account_id);
            }
        }

        //TODO Enviar email de notificação.

        if (!$result > 0)
            throw new Exception('Error updating an account.');

        return $result;
    }

    /**
     * Change an password from an account.
     *
     * @param int $account_id User account ID
     * @param string $new_password New password
     * @param string $password Current password
     * @param bool $notify_email Notify user by email
     * @return mixed
     * @todo Enviar email de notificação (opcional)
     */
    public function change_password($account_id, $new_password, $password = NULL, $force_confirmation = FALSE, $notify_email = FALSE)
    {
        $user = $this->account->find($account_id);
        if ($force_confirmation == true && ($password === null || !$this->_check_hash_password($user->id, $password, $user->password))) {
            return false;
        }
        if ($user) {
            return $this->account->update($account_id, array('password' => $this->_hash_password($new_password)));
        }
        return false;
    }

    /**
     * Activate an account.
     *
     * @param int $account_id
     * @return mixed
     * @throws Exception
     */
    public function activate($account_id = NULL)
    {
        $result = $this->account->update($account_id, array('status' => 1));
        if (!$result > 0)
            throw new Exception('Error activating account.');
        return $result;
    }

    /**
     * Activate an account by Token.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param string $token
     * @return mixed
     * @throws Exception
     */
    public function activate_token_account($token = NULL)
    {
        if ($token == NULL)
            throw new Exception('Nenhum token válido foi informado.');
        $result = $this->account->update_by('token', $token, array('status' => 1));
        if (!$result > 0)
            throw new Exception('falha na ativação pelo token do usuário.');
        return $result;
    }

    /**
     * Deactiate an account.
     *
     * @param int $account_id
     * @return mixed
     * @throws Exception
     */
    public function deactivate($account_id = NULL)
    {
        $result = $this->account->update($account_id, array('status' => 0));
        if (!$result > 0)
            throw new Exception('Error activating account.');
        return $result;
    }

    /**
     * Delete an account.
     *
     * @param int $account_id
     * @return mixed
     */
    public function delete($account_id = NULL)
    {
        return $this->account->delete($account_id);
    }

    /**
     * Send a password recovery confirmation by email.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param string $email
     * @return boolean
     */
    public function send_recovery($email = NULL)
    {
        $query = $this->account->find_by('email', $email);
        $data_message = array(
            'email' => $email,
            'token' => $query->token
        );
        $data_email = array(
            'html' => TRUE,
            'from_name' => wpn_config('site_titulo'),
            'from_email' => wpn_config('site_contato'),
            'to' => $email,
            'subject' => 'Recuperação de senha.',
            'message' => $this->load->view('emails/account_recovery', $data_message, TRUE),
        );
        if ($this->wpanel->send_email($data_email))
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Recovery password from an account by token and send an confirmation
     * message by email.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param string $token
     * @return boolean
     */
    public function recovery($token = NULL)
    {
        if ($token == NULL)
            return FALSE;
        $account = $this->get_account_by_token($token);
        if (@count($account))
        {
            $new_password = $this->_generate_pass();
            $data_update = array(
                'token' => $this->_generate_token(),
                'password' => $this->_hash_password($new_password)
            );
            if ($this->account->update($account->id, $data_update))
            {
                // Envia as novas credenciais.
                $data_email = array(
                    'html' => TRUE,
                    'from_name' => wpn_config('site_titulo'),
                    'from_email' => wpn_config('site_contato'),
                    'to' => $account->email,
                    'subject' => 'Novos dados de acesso.',
                    'message' => $this->load->view('emails/account_credentials', array('email' => $account->email, 'password' => $new_password), TRUE),
                );
                $this->wpanel->send_email($data_email);
                return TRUE;
            } else
                return FALSE;
        } else
            return FALSE;
    }

    /**
     * This function sets an regular account login.
     *
     * @param string $email
     * @param string $password
     * @param bool $remember
     * @param string $backlink
     * @return boolean
     */
    public function login($email, $password, $remember = FALSE, $backlink = NULL)
    {
        if ($this->config->item('auth_enable_ip_banned') and $this->_is_banned())
            return FALSE;
        $query = $this->account->find_by(array('email' => $email, 'status' => 1));
        if ($query)
        {
            if ($this->_check_hash_password($query->id, $password, $query->password)) {
                $this->_clear_attempt();
                $this->_set_session($query);
                $this->_add_access($query->id);
                return TRUE;
            } else {
                return FALSE;
            }
        } else
        {
            if ($this->_num_attempts() >= $this->config->item('auth_max_attempts'))
            {
                if ($this->config->item('auth_enable_autoban') == TRUE)
                    $this->_ban_ip();

                return FALSE;
            }
            $this->_add_attempt();
            return FALSE;
        }
    }

    /**
     * Logout user from login.
     *
     * @return bool
     */
    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('extra_data');
        $this->session->unset_userdata('created_on');
        $this->session->unset_userdata('logged_in');
        return TRUE;
    }

    /**
     * Check if user is logged.
     *
     * @return boolean
     */
    public function is_logged()
    {
        if ($this->session->userdata('logged_in'))
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Return true if the logged user is 'user'.
     *
     * @return boolean
     */
    public function is_user()
    {
        if ($this->session->userdata('role') == 'user')
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Return true if the logged user is 'admin'.
     *
     * @return boolean
     */
    public function is_admin()
    {
        if ($this->session->userdata('role') == 'admin')
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Return true if the logged user is 'ROOT'.
     *
     * @return boolean
     */
    public function is_root()
    {
        if ($this->session->userdata('role') == 'ROOT')
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Returns the logged user ID.
     *
     * @return int
     */
    public function user_id()
    {
        if ($this->is_logged())
            return $this->session->userdata('id');
        else
            return 0;
    }

    /**
     * Return an account object. If $id is empty, return the logged account.
     *
     * @param int $account_id
     * @return object
     */
    public function account($account_id = NULL)
    {
        if ($account_id == NULL)
            $account_id = $this->user_id();

        return $this->account->find($account_id);
    }

    /**
     * Return an account list.
     *
     * @param string $role
     * @return mixed
     */
    public function account_all($role = null)
    {
        if ($role == NULL)
            return $this->account->find_all();
        else
            return $this->account->find_many_by('role', $role);
    }

    /**
     * Return the 'extra_data' collumn as object from an logged user or 
     * indicated by ID.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param int $account_id Account ID.
     * @return object
     */
    public function profile($account_id = NULL)
    {
        $query = $this->account($account_id);
        return (object) json_decode($query->extra_data);
    }

    /**
     * Check if an email exists.
     *
     * @param string $email
     * @return bool
     */
    public function email_exists($email)
    {
        $query = $this->account->find_by('email', $email);
        if (empty($query))
            return FALSE;
        else
            return TRUE;
    }

    /**
     * Call the check_permission() method inside a Hook.
     *
     * @return mixed
     */
    public function check_permission_by_hook()
    {
        if ($this->config->item('auth_check_permyssion_by_hook') == TRUE)
            return $this->check_permission();
    }

    /**
     * Check permission method.
     *
     * Example of usage:
     * -------------------------------------------------------------------------
     * Inside a construction to check all methods. You can put inside a method
     * for a more especific check.
     *
     * public function __construct()
     * {
     *     $this->auth->check_permission();
     * }
     * -------------------------------------------------------------------------
     *
     * @param string $url
     * @return boolean
     */
    public function check_permission($url = NULL)
    {
        if ($this->user_id() == '')
        {
            $this->session->flashdata('msg_auth', 'User is not logged.');
            redirect('admin/logout');
            exit;
        } else
        {
            if ($url == NULL)
            {
                $url = $this->uri->uri_string();
                ($this->uri->total_segments() == 3) ? $url . '/' : $url;
            }
            if ($this->session->userdata('role') == 'ROOT')
                return TRUE;
            if ($url == '')
                return TRUE;
            if (in_array($this->_prepare_url($url), $this->auth_white_list))
                return TRUE;
            if ($this->_in_whitelist($this->_prepare_url($url)))
                return TRUE;
            if ($this->_is_paginate($url))
                return TRUE;
            if ($this->permission->validate_permission($this->user_id(), $this->_prepare_url($url)) === false)
            {
                $this->session->flashdata('msg_sistema', 'User don\'t has permission.');
                redirect('admin/dashboard');
                exit;
            }
            return TRUE;
        }
    }

    /**
     * Libera a permissão no caso de uma paginação.
     *
     * @param String $url
     * @return Bool
     */
    private function _is_paginate($url)
    {
        $x = explode('/', $url);
        if (@$x[3] == 'pag')
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Check link permission for users.
     *
     * @param String $url Some link Eg. 'admin/users'
     * @param Integer $account_id
     * @param Bool $override_root
     * @return Mixed
     */
    public function link_permission($url, $account_id = NULL, $override_root = FALSE)
    {
        if ($account_id == NULL)
            $account_id = $this->user_id();
        if ($this->session->userdata('role') == 'ROOT' && $override_root == FALSE)
            return TRUE;
        else
            return $this->permission->validate_permission($account_id, $url);
    }

    /**
     * Check if Accounts is empty.
     *
     * @return boolean
     */
    public function accounts_empty()
    {
        $result = $this->account->count_all();
        if ($result > 0)
            return FALSE;
        else
            return TRUE;
    }

    /**
     * This function generate an unique token.
     * 
     * @return string
     */
    public function _generate_token()
    {
        $token = rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
        $account = $this->get_account_by_token($token);
        if (@count($account) > 0)
            return $this->_generate_token();
        else
            return $token;
    }

    /**
     * Return an random number based on an sha256 hash.
     * 
     * @return string
     */
    private function getRandomNumber()
    {
        return hash('sha256', uniqid(mt_rand(), true), true);
    }

    /**
     * Get an account data by Token.
     * 
     * @param string $token
     * @return object
     */
    public function get_account_by_token($token)
    {
        return $this->account->find_by('token', $token);
    }

    /**
     * Return a hashed password.
     *
     * @param $password
     * @param string $salt
     * @return string
     */
    private function _hash_password($password)
    {
        switch ($this->auth_password_hash_type)
        {
            case 'md5':
                return md5($password . $this->auth_password_hash_salt);
                break;
            case 'sha512':
                return hash('sha512', $password . $this->auth_password_hash_salt);
                break;
            case 'php' :
                return password_hash($password, PASSWORD_DEFAULT);
                break;
        }
    }
    
    /**
     * Check an password hash.
     * 
     * @param int $account_id Account ID.
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    private function _check_hash_password($account_id, $password, $hash)
    {
        switch ($this->auth_password_hash_type)
        {
            case 'md5':
                if ($hash == md5($password . $this->auth_password_hash_salt))
                    return TRUE;
                else
                    return FALSE;
                break;
            case 'sha512':
                if ($hash == hash('sha512', $password . $this->auth_password_hash_salt))
                    return TRUE;
                else
                    return FALSE;
                break;
            case 'php' :
                if (password_verify($password, $hash)) {
                    if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                        // salva o novo hash.
                        $data = array('password' => $this->_hash_password($password));
                        $this->account->update($account_id, $data);
                    }
                    return TRUE;
                } else
                    return FALSE;
                break;
        }
    }

    /**
     * Setup a login session.
     *
     * @param object $account
     * @return bool
     */
    private function _set_session($account)
    {
        if (!$account->id)
            return FALSE;
        $object = (object) json_decode($account->extra_data);
        $data = array(
            'id' => $account->id,
            'email' => $account->email,
            'role' => $account->role,
            'extra_data' => $object,
            'created_on' => $account->created_on,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($data);
    }

    /**
     * Create permissions for an account.
     *
     * @param int $action_id
     * @param int $account_id
     * @return int
     */
    private function _create_permission($action_id, $account_id)
    {
        $data = array(
            'module_id' => 0,
            'module_action_id' => $action_id,
            'account_id' => $account_id
        );
        return $this->permission->insert($data);
    }

    /**
     * Remove permissions from an account. Usefull to update account.
     *
     * @param int $account_id
     * @return mixed
     */
    private function _remove_permission($account_id)
    {
        return $this->permission->delete_by('account_id', $account_id);
    }

    /**
     * Check if the current IP addres is banned.
     *
     * @return boolean
     */
    private function _is_banned()
    {        
        if ($this->ipallowed->is_whitelisted($_SERVER['REMOTE_ADDR'])) {
            return FALSE;
        } else {
            $result = $this->ipban->count_by('ip_address', $_SERVER['REMOTE_ADDR']);
            if($result > 0)
                return TRUE;
            else
                return FALSE;
        }
    }

    /**
     * Ban an IP address after many failed attempts to login.
     *
     * @return mixed
     */
    private function _ban_ip()
    {
        $data = array();
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        return $this->ipban->insert($data);
    }

    /**
     * Increase the numbe of attempts of failed login.
     *
     * @return void
     */
    private function _add_attempt()
    {
        $query = $this->ipattempt->find_by('ip_address', $_SERVER['REMOTE_ADDR']);
        if ($query)
        {
            $data = array();
            $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $data['last_failed_attempt'] = date('Y-m-d H:i:s');
            $data['number_of_attempts'] = $query->number_of_attempts + 1;
            $this->ipattempt->update($query->id, $data);
        } else
        {
            $data = array();
            $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $data['last_failed_attempt'] = date('Y-m-d H:i:s');
            $data['number_of_attempts'] = 1;
            $this->ipattempt->insert($data);
        }
    }

    /**
     * Clear the login attempts from an Ip address.
     *
     * @return int
     */
    private function _clear_attempt()
    {
        $this->ipattempt->delete_by('ip_address', $_SERVER['REMOTE_ADDR']);
    }

    /**
     * Return a number of attempts of login from the Ip Address.
     *
     * @return int
     */
    private function _num_attempts()
    {
        $result = $this->ipattempt->find_by('ip_address', $_SERVER['REMOTE_ADDR']);
        return $result ? $result->number_of_attempts : 0;
    }

    /**
     * Log the account logins.
     *
     * @param int $account_id
     * @param string $ip_address
     * @return mixed
     */
    private function _add_access($account_id)
    {
        $data = array();
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        return $this->logaccess->insert($data);
    }

    /**
     * Prepare an URL to set an permission list.
     * 
     * @param string $url
     * @return string
     */
    private function _prepare_url($url)
    {
        $x = explode('/', $url);
        $out = '';
        $bar = '/';
        foreach ($x as $key => $value)
        {
            if ($key > 2)
                $value = '*';
            if ($key == 0)
                $out .= $value;
            else
                $out .= $bar . $value;
        }
        return $out;
    }

    /**
     * Check ir an $url is in white list.
     *
     * @param string $url
     * @return boolean
     */
    private function _in_whitelist($url)
    {
        $where = array(
            'link' => $url,
            'whitelist' => 1,
        );
        $result = $this->module_action->find_by($where);
        if ($result)
            return TRUE;
        else
            return FALSE;
    }

    /**
     * This function generate random passwords.
     *
     * @author Thiago Belem <contato@thiagobelem.net>
     *
     * @param integer $tamanho Tamanho da senha a ser gerada
     * @param boolean $maiusculas Se terá letras maiúsculas
     * @param boolean $numeros Se terá números
     * @param boolean $simbolos Se terá símbolos
     *
     * @return string A senha gerada
     */
    private function _generate_pass($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas)
            $caracteres .= $lmai;
        if ($numeros)
            $caracteres .= $num;
        if ($simbolos)
            $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++)
        {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

}
