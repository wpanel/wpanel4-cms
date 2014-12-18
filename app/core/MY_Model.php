<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Esta classe faz uma extensão ao CodeIgniter com os métodos mais usados
 * nos meus projetos.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 04/10/2014
 */

class MY_Model extends CI_Model
{
    /**
     * Esta variável recebe o nome da tabela do banco de dados.
     *
     * @var $table_name string
     **/
    public $table_name;

    /**
     * Esta variável recebe o nome da chave-primária da tabela.
     *
     * @var $primary_key string
     **/
    public $primary_key;
    
    /**
     * Construtor da classe.
     **/
    function __construct() 
    {
        parent::__construct();
    }

    /**
     * Este método retorna todos os registros da tabela.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $order array - Array com a ordenação dos resultados.
     * @param $limit array Um array com os detalhes de limite, Ex: array('offset'=>'0', 'limit'=>'10')
     * @return mixed
     **/
    public function get_list($order = array(), $limit = array())
    {
        if ((is_array($order)) and (count($order)!=0)) 
        {
            $this->db->order_by($order['field'], $order['order']);
        }
        if((is_array($limit)) and (count($limit) != 0))
        {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        return $this->db->get($this->table_name);
    }
    
    /**
     * Este método retorna o total de registros da tabela.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return int
     **/
    public function count_all() 
    {
        return $this->db->count_all($this->table_name);
    }
    
    /**
     * Este método retorna um registro de indicando o valor de sua chave-primária.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $id int - Valor da chave-primaria
     * @return mixed
     **/
    public function get_by_id($id) 
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->get($this->table_name);
    }

    /**
     * Este método é semelhante ao get_by_id() com a diferença que com ele
     * informamos o campo que será usado como filtro.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $field string - Campo que será usado como filtro.
     * @param $value string - Valor a ser filtrado.
     * @param $order array - Array com a ordenação dos resultados.
     * @param $limit array Um array com os detalhes de limite, Ex: array('offset'=>'0', 'limit'=>'10')
     * @return mixed
     **/
    public function get_by_field($field, $value = null, $order = array(), $limit = array())
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
        if((is_array($limit)) and (count($limit) != 0))
        {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        return $this->db->get($this->table_name);
    }
    
    /**
     * Este método salva um novo registro na tabela usando um
     * array para transmitir os dados.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $dados array - Array com os dados que serão salvos.
     * @return mixed
     **/
    public function save($dados)
    {
        $this->db->insert($this->table_name, $dados);
        return $this->db->insert_id();
    }
    
    /**
     * Este método faz a alteração de um registro infornando o valor
     * se sua chave-primária e um array com os novos dados.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $id int - Valor da chave primária.
     * @param $dados array - Array com os novos dados.
     * @return mixed
     **/
    public function update($id, $dados)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->table_name, $dados);
        return $this->db->affected_rows();
    }

    /**
     * Este método exclui um registro da tabela infornando
     * o valor de sua chave-primária.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $id int - Valor da chave-primária.
     * @return mixed
     */
    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

}

// End class MY_Model