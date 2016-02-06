<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_item extends MY_Model {

    public $table_name = 'menu_itens';
    public $primary_key = 'id';

    public function delete_by_menu($menu_id)
    {
    	$this->db->where('menu_id', $menu_id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

}
