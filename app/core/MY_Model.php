<?php

/**
 * Esta classe faz uma extensão ao CodeIgniter com os métodos mais usados
 * nos meus projetos.
 * 
 * @author Eliel de Paula <elieldepaula@gmail.com>
 * @since 0.1 04/10/2014
 */

class MY_Model extends CI_Model
{
    
    public $table_name;
    public $primary_key;
    
    function __construct() 
    {
        parent::__construct();
    }

    public function list_all($order = array())
    {
        if ((is_array($order)) and (count($order)!=0)) 
        {
            $this->db->order_by($order['field'], $order['order']);
        }
        return $this->db->get($this->table_name);
    }
    
    public function count_all() 
    {
        return $this->db->count_all($this->table_name);
    }
    
    public function get_paged_list($offset = 0, $limit = 10, $order = array())
    {
        if ((is_array($order)) and (count($order)!=0)) 
        {
            $this->db->order_by($order['field'], $order['order']);
        }
        return $this->db->get($this->table_name, $limit, $offset);
    }
    
    public function get_by_id($id) 
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->get($this->table_name);
    }

    public function get_by_field($field, $value = null, $order = array())
    {
        if (is_array($field))
        {
            foreach ($field as $key => $value) 
            {
                $this->db->where($key, $value);
            }
        } 
        else 
        {
            $this->db->where($field, $value);
        }
        if ((is_array($order)) and (count($order)!=0)) 
        {
            $this->db->order_by($order['field'], $order['order']);
        }

        return $this->db->get($this->table_name);
    }
    
    public function save($dados)
    {
        $this->db->insert($this->table_name, $dados);
        return $this->db->insert_id();
    }
    
    public function update($id, $dados)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->table_name, $dados);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

    public function relacionamento($chave = '', $valor = '')
    {
        if ($valor)
        {
            $this->db->where($chave, $valor);
        }
        return $this->db->get($this->table_name);
    }
}