<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends MY_Model {

	public $table_name = 'categories';
	public $primary_key = 'id';

	public function get_by_post($post_id = 0, $order = 'asc', $limit = array())
	{
		$this->db->select('categories.*, posts_categories.post_id, posts_categories.category_id');
		$this->db->from($this->table_name);
		$this->db->join('posts_categories', 'posts_categories.category_id = categories.id');
		$this->db->where('posts_categories.post_id', $post_id);
		if((is_array($limit)) and (count($limit) != 0))
        {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
		return $this->db->get();
	}

	/*
	| Retorna o título da categoria passando o ID
	| usado na lista de categorias para nomear as sub-categorias.
	*/
	public function get_title_by_id($id)
	{
		if($id){
			$query = $this->get_by_id($id, null, null, 'title')->row();
			return $query->title;
		} else
			return false;
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