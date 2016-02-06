<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria extends MY_Model {

	public $table_name = 'categories';
	public $primary_key = 'id';

	/*
	| Retorna o título da categoria passando o ID
	*/
	public function get_title_by_id($id)
	{
		$this->db->where($this->primary_key, $id);
        $query = $this->db->get($this->table_name)->row();
        return @$query->title;
	}

	/*
	| Exclui as categorias pelo ID da categoria-pai.
	*/
	public function delete_son($id)
	{
		$this->db->where('category_id', $id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
	}

}