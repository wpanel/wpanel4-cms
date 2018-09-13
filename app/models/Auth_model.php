<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Auth_model
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Auth_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // Cria uma nova conta.
    public function insert_account($data)
    {
        $this->db->insert('accounts', $data);
        return $this->db->insert_id();
    }

    public function insert_permission($data)
    {
        $data['module_id'] = $this->_get_module_from_action($data['module_action_id']);
        $this->db->insert('permissions', $data);
        return $this->db->insert_id();
    }

    // Atualiza uma conta
    public function update_account($data)
    {
        $id = $data['id']; // Recupera o ID.
        unset($data['id']); // Remove o ID do array de atualização.
        $this->db->where('id', $id);
        $this->db->update('accounts', $data);
        return $this->db->affected_rows();
    }

    // Atualiza a senha de uma conta
    public function update_password($data)
    {
        // Verifica se foi passado a senha anterior e faz a verificação.
        if (isset($data['old_password']))
            $this->db->where('password', $data['old_password']);
        $this->db->where('id', $data['id']);
        $this->db->update('accounts', array('password' => $data['new_password'], 'updated' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function activate_account($account_id = NULL)
    {
        $this->db->where('id', $account_id);
        $this->db->update('accounts', array('status' => 1));
        return $this->db->affected_rows();
    }

    public function deactivate_account($account_id = NULL)
    {
        $this->db->where('id', $account_id);
        $this->db->update('accounts', array('status' => 0));
        return $this->db->affected_rows();
    }

    public function remove_account($account_id = NULL)
    {
        $this->db->where('id', $account_id);
        $this->db->delete('accounts');
        return $this->db->affected_rows();
    }

    // Ferifica o login de uma conta
    public function login_account($data)
    {
        // Verifica se o IP está banido.
        if ($this->config->item('auth_enable_ip_banned') == TRUE and $this->_check_ip_banned($_SERVER['REMOTE_ADDR']) > 0)
            return FALSE;
        // Verifica se o IP excedeu o limite de tentativas.
        if ($this->_check_attempt($_SERVER['REMOTE_ADDR']))
        {
            // Verifica se deve banir automaticamente o IP.
            if ($this->config->item('auth_enable_autoban') == TRUE)
                $this->_ban_ip($_SERVER['REMOTE_ADDR']);
            return FALSE;
        }

        $this->db->where('email', $data['email']);
        $this->db->where('password', $data['password']);
        $this->db->where('status', 1);
        $query = $this->db->get('accounts');
        if ($query->num_rows() > 0)
        {
            // Verifica se deve registrar o login.
            if ($this->config->item('auth_log_access') == TRUE)
            {
                $user = $query->row();
                $temp = array('user_id' => $user->id, 'ip_address' => $_SERVER['REMOTE_ADDR'], 'created' => date('Y-m-d H:i:s'));
                $this->db->insert('log_access', $temp);
            }
            $this->_clear_attempt($_SERVER['REMOTE_ADDR']);
            return $query->row();
        } else
        {
            $this->_add_attempt($_SERVER['REMOTE_ADDR']);
            return FALSE;
        }
    }

    // Verifica se o email já existe.
    public function email_exists($email)
    {
        $this->db->select('id');
        $this->db->where('email', $email);
        $num = $this->db->get('accounts')->num_rows();
        return ($num > 0);
    }

    // Verifica se existe alguma conta.
    public function accounts_empty()
    {
        $this->db->select('id');
        $this->db->where('role', 'admin');
        $this->db->or_where('role', 'ROOT');
        $account = $this->db->get('accounts')->num_rows();
        if ($account > 0)
            return FALSE;
        else
            return TRUE;
    }

    // Lista todas as contas.
    public function all_accounts($order = array(), $limit = array(), $select = null)
    {
        if ($select != null)
            $this->db->select($select);
        if ((is_array($order)) and ( count($order) != 0))
            $this->db->order_by($order['field'], $order['order']);
        if ((is_array($limit)) and ( count($limit) != 0))
            $this->db->limit($limit['limit'], $limit['offset']);
        return $this->db->get('accounts');
    }

    public function account_by_id($id = NULL)
    {
        if ($id == NULL)
            return FALSE;
        //throw new Exception('Account ID is empty.');
        $this->db->where('id', $id);
        $account = $this->db->get('accounts');
        if ($account->num_rows() > 0)
            return $account->row();
        else
            return FALSE;
    }

    // Exemplo retirado do projeto ACL no Github.
    public function validate_permission($account_id, $url)
    {
        $this->db->select('permissions.*');
        $this->db->from('permissions');
        $this->db->join('modules_actions', 'modules_actions.id = permissions.module_action_id');
        $this->db->where('modules_actions.link', $url);
        $this->db->where('permissions.account_id', $account_id);
        $this->db->where('modules_actions.whitelist', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    // Valida a lista branca - retirado do projeto ACL no Github.
    public function validate_white_list($url)
    {
        $this->db->select('modules_actions.link');
        $this->db->where('modules_actions.link', $url);
        $this->db->where('modules_actions.whitelist', 1);
        $query = $this->db->get('modules_actions');
        if ($query->num_rows() == 0)
            return false;

        return true;
    }

    // Remove as permissões de uma conta.
    public function remove_permission_by_account($account_id = NULL)
    {
        if ($account_id == NULL)
            return FALSE;
        $this->db->where('account_id', $account_id);
        $this->db->delete('permissions');
        return $this->db->affected_rows();
    }

    private function _get_module_from_action($action_id)
    {
        $this->db->select('module_id');
        $this->db->where('id', $action_id);
        $query = $this->db->get('modules_actions')->row();
        return $query->module_id;
    }

    // Cria um novo registro de tentativa.
    private function _add_attempt($ip_address = NULL)
    {
        $this->db->select('id');
        $this->db->where('ip_address', $ip_address);
        $_attempts = $this->db->get('ip_attempts');
        $num_rows = $_attempts->num_rows();
        if ($num_rows > 0)
        {
            // existe, update: adicionar +1
            $this->db->set('number_of_attempts', 'number_of_attempts+1', FALSE);
            $this->db->set('last_failed_attempt', date('Y-m-d H:i:s'));
            $this->db->set('updated', date('Y-m-d H:i:s'));
            $this->db->where('ip_address', $ip_address);
            $this->db->update('ip_attempts');
        } else
        {
            // nao existe, criar o primeiro
            $this->db->set('ip_address', $ip_address);
            $this->db->set('number_of_attempts', '1');
            $this->db->set('last_failed_attempt', date('Y-m-d H:i:s'));
            $this->db->set('created', date('Y-m-d H:i:s'));
            $this->db->set('updated', date('Y-m-d H:i:s'));
            $this->db->insert('ip_attempts');
        }
    }

    private function _ban_ip($ip_address = NULL)
    {
        if ($this->_check_ip_banned($ip_address) == FALSE)
        {
            $this->db->set('ip_address', $ip_address);
            $this->db->set('created', date('Y-m-d H:i:s'));
            return $this->db->insert('ip_banned');
        } else
            return FALSE;
    }

    // Verifica se já atingiu o total permitido de tentativas.
    // retorna true se atingiu o total de tentativas e false se nao atingiu.
    private function _check_attempt($ip_address = NULL)
    {
        $this->db->where('ip_address', $ip_address);
        $query = $this->db->get('ip_attempts')->row();
        if ($query->number_of_attempts >= $this->config->item('auth_max_attempts'))
        {
            return TRUE;
        } else
            return FALSE;
    }

    // Limpa as tentativas em caso de acerto.
    private function _clear_attempt($ip_address = NULL)
    {
        $this->db->where('ip_address', $ip_address);
        $this->db->delete('ip_attempts');
        return $this->db->affected_rows();
    }

    // Verifica se o IP está na lista de IP's banidos.
    private function _check_ip_banned($ip_address = NULL)
    {
        $this->db->select('id');
        $this->db->where('ip_address', $ip_address);
        $num = $this->db->get('ip_banned')->num_rows();
        return ($num > 0);
    }

}
