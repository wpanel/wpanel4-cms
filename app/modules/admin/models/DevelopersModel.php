<?php

/**
 * Description of Developers
 *
 * @author elieldepaula
 */
class DevelopersModel extends CI_Model {
    
    public function get_migration_version()
    {
        $this->db->select('version');
        $query = $this->db->get('migrations');
        return $query->row()->version;
    }
    
    public function get_migration_list()
    {
        $migration_files = $this->migration->find_migrations();
        $array_lista = array();
        foreach ($migration_files as $key => $value) {
            $array_lista[$key] = $key;
        }
        return $array_lista;
    }
    
}
