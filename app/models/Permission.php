<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Permission
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Permission extends MY_Model
{

    public $table_name = 'permissions';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = FALSE;
    protected $log_user = FALSE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;

    /**
     * Validate an permission user by url.
     * 
     * @param int $account_id
     * @param string $url
     * @return boolean
     */
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

}
