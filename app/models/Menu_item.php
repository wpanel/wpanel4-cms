<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Menu_item
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Menu_item extends MY_Model 
{

    public $table_name = 'menu_itens';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = false;
    protected $log_user = TRUE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;

    /**
     * Delete items by menu id.
     * 
     * @param int $menu_id
     * @return mixed
     */
    public function delete_by_menu($menu_id)
    {
    	$this->db->where('menu_id', $menu_id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

}
