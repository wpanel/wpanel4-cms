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
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
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

class Auth_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new account.
     * 
     * @param array $data
     * @return mixed
     */
    public function insert_account($data)
    {
        $this->db->insert('accounts', $data);
        return $this->db->insert_id();
    }

    /**
     * Create the permissions to an account.
     * 
     * @param array $data
     * @return mixed
     */
    public function insert_permission($data)
    {
        $data['module_id'] = $this->_get_module_from_action($data['module_action_id']);
        $this->db->insert('permissions', $data);
        return $this->db->insert_id();
    }

    /**
     * Update an account.
     * 
     * @param array $data
     * @return mixed
     */
    public function update_account($data)
    {
        $id = $data['id'];
        unset($data['id']);
        $this->db->where('id', $id);
        $this->db->update('accounts', $data);
        return $this->db->affected_rows();
    }

    /**
     * Update an password from an account.
     * 
     * @param array $data
     * @return mixed
     */
    public function update_password($data)
    {
        if (isset($data['old_password']))
            $this->db->where('password', $data['old_password']);
        $this->db->where('id', $data['id']);
        $this->db->update('accounts', array('password' => $data['new_password'], 'updated' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    /**
     * Activate an account.
     * 
     * @param int $account_id Account Id.
     * @return mixed
     */
    public function activate_account($account_id = NULL)
    {
        $this->db->where('id', $account_id);
        $this->db->update('accounts', array('status' => 1));
        return $this->db->affected_rows();
    }

    /**
     * Deactivate an account.
     * 
     * @param int $account_id Account Id.
     * @return mixed
     */
    public function deactivate_account($account_id = NULL)
    {
        $this->db->where('id', $account_id);
        $this->db->update('accounts', array('status' => 0));
        return $this->db->affected_rows();
    }

    /**
     * Remove an account.
     * 
     * @param int $account_id Account Id.
     * @return mixed
     */
    public function remove_account($account_id = NULL)
    {
        $this->db->where('id', $account_id);
        $this->db->delete('accounts');
        return $this->db->affected_rows();
    }

    /**
     * This method check and log in an usser account.
     * 
     * @param array $data
     * @return mixed
     */
    public function login_account($data)
    {
        // Check the Ip Ban.
        if ($this->config->item('auth_enable_ip_banned') == TRUE and $this->_check_ip_banned($_SERVER['REMOTE_ADDR']) > 0)
            return FALSE;
        // Check the login attempts.
        if ($this->_check_attempt($_SERVER['REMOTE_ADDR']))
        {
            // Check the auto ban config.
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

    /**
     * Check if the email exists.
     * 
     * @param string $email Email.
     * @return mixed
     */
    public function email_exists($email)
    {
        $this->db->select('id');
        $this->db->where('email', $email);
        $num = $this->db->get('accounts')->num_rows();
        return ($num > 0);
    }

    /**
     * check if the account table is empty.
     * 
     * @return boolean
     */
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

    /**
     * List all accounts.
     * 
     * @param array $order
     * @param array $limit
     * @param string $select
     * @return mixed
     */
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

    /**
     * Return an account by the Id.
     * 
     * @param int $id Account Id.
     * @return mixed
     */
    public function account_by_id($id = NULL)
    {
        if ($id == NULL)
            return FALSE;
        $this->db->where('id', $id);
        $account = $this->db->get('accounts');
        if ($account->num_rows() > 0)
            return $account->row();
        else
            return FALSE;
    }

    /**
     * Check if some account has permission to some URI.
     * 
     * @param int $account_id
     * @param string $uri
     * @return boolean
     */
    public function validate_permission($account_id, $uri)
    {
        $this->db->select('permissions.*');
        $this->db->from('permissions');
        $this->db->join('modules_actions', 'modules_actions.id = permissions.module_action_id');
        $this->db->where('modules_actions.link', $uri);
        $this->db->where('permissions.account_id', $account_id);
        $this->db->where('modules_actions.whitelist', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    /**
     * Check if some Uri is on the White List.
     * 
     * @param string $uri
     * @return boolean
     */
    public function validate_white_list($uri)
    {
        $this->db->select('modules_actions.link');
        $this->db->where('modules_actions.link', $uri);
        $this->db->where('modules_actions.whitelist', 1);
        $query = $this->db->get('modules_actions');
        if ($query->num_rows() == 0)
            return false;

        return true;
    }

    /**
     * Remove the permissions to an account.
     * 
     * @param int $account_id
     * @return mixed
     */
    public function remove_permission_by_account($account_id = NULL)
    {
        if ($account_id == NULL)
            return FALSE;
        $this->db->where('account_id', $account_id);
        $this->db->delete('permissions');
        return $this->db->affected_rows();
    }

    /**
     * Return the 'module_id' field from the module table list.
     * 
     * @param int $action_id
     * @return mixed
     */
    private function _get_module_from_action($action_id)
    {
        $this->db->select('module_id');
        $this->db->where('id', $action_id);
        $query = $this->db->get('modules_actions')->row();
        return $query->module_id;
    }

    /**
     * This method add a new attempt to login from an Ip.
     * 
     * @param string $ip_address
     */
    private function _add_attempt($ip_address = NULL)
    {
        $this->db->select('id');
        $this->db->where('ip_address', $ip_address);
        $_attempts = $this->db->get('ip_attempts');
        $num_rows = $_attempts->num_rows();
        if ($num_rows > 0)
        {
            $this->db->set('number_of_attempts', 'number_of_attempts+1', FALSE);
            $this->db->set('last_failed_attempt', date('Y-m-d H:i:s'));
            $this->db->set('updated', date('Y-m-d H:i:s'));
            $this->db->where('ip_address', $ip_address);
            $this->db->update('ip_attempts');
        } else
        {
            $this->db->set('ip_address', $ip_address);
            $this->db->set('number_of_attempts', '1');
            $this->db->set('last_failed_attempt', date('Y-m-d H:i:s'));
            $this->db->set('created', date('Y-m-d H:i:s'));
            $this->db->set('updated', date('Y-m-d H:i:s'));
            $this->db->insert('ip_attempts');
        }
    }

    /**
     * Ban an Ip.
     * 
     * @param string $ip_address
     * @return mixed
     */
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

    /**
     * Check the current attempt is the max of attempts to login.
     * 
     * @param string $ip_address
     * @return boolean
     */
    private function _check_attempt($ip_address = NULL)
    {
        $this->db->where('ip_address', $ip_address);
        $query = $this->db->get('ip_attempts')->row();
        if ($query->number_of_attempts >= $this->config->item('auth_max_attempts'))
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Clear the attempt count for an IP when the login succeed.
     * 
     * @param string $ip_address
     * @return mixed
     */
    private function _clear_attempt($ip_address = NULL)
    {
        $this->db->where('ip_address', $ip_address);
        $this->db->delete('ip_attempts');
        return $this->db->affected_rows();
    }

    /**
     * Check if an IP is in the banned list.
     * 
     * @param string $ip_address
     * @return int
     */
    private function _check_ip_banned($ip_address = NULL)
    {
        $this->db->select('id');
        $this->db->where('ip_address', $ip_address);
        $num = $this->db->get('ip_banned')->num_rows();
        return ($num > 0);
    }

}
