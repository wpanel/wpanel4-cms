<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_categoria extends MY_Model {

	public $table_name = 'posts_categories';
	public $primary_key = 'id';

	public function delete_by_post($id_post)
	{
		$this->db->where('post_id', $id_post);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
	}

}
