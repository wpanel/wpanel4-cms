<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Categoria
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Category extends MY_Model
{

    public $table_name = 'categories';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = TRUE;
    protected $log_user = TRUE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;

    /**
     * Get categories by post id.
     * 
     * @param int $post_id
     * @param string $order
     * @param array $limit
     * @return mixed
     */
    public function get_by_post($post_id = 0, $order = 'asc', $limit = array())
    {
        $this->db->select('categories.id, categories.title, categories.link, posts_categories.post_id, posts_categories.category_id');
        $this->db->from($this->table_name);
        $this->db->join('posts_categories', 'posts_categories.category_id = categories.id');
        $this->db->where('posts_categories.post_id', $post_id);
        if ((is_array($limit)) and ( count($limit) != 0))
        {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        return $this->db->get();
    }

    /**
     * Return title by ID.
     * 
     * @param int $id
     * @return mixed
     */
    public function get_title_by_id($id)
    {
        if ($id)
        {
            $query = $this->select('title')->find($id);
            return $query->title;
        } else
            return false;
    }

    /**
     * Delete categories by category_id field.
     * 
     * @param int $id
     * @return mixed
     */
    public function delete_son($id)
    {
        $this->db->where('category_id', $id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

}
