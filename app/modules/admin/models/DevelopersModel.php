<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe model DevelopersModel.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class DevelopersModel extends CI_Model {
    
    /**
     * Retorna o número da versão.
     * 
     * @return bigint
     */
    public function get_migration_version()
    {
        $this->db->select('version');
        $query = $this->db->get('migrations');
        return $query->row()->version;
    }
    
    /**
     * Retorna a lista de arquivos de migração.
     * 
     * @return array
     */
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
