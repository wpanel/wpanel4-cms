<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Post
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Post extends MY_Model
{

    public $table_name = 'posts';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = TRUE;
    protected $log_user = TRUE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;

    /**
     * Return posts and categories by category_id.
     *
     * @return mixed
     * @param $category_id int Código da categoria.
     * @param $order  string Tipo de ordenação do resultado ASC ou DESC.
     * @param $limit array Um array com os detalhes de limite, Ex: array('offset'=>'0', 'limit'=>'10')
     * @author Eliel de Paula <elieldepaula@gmail.com>
     * */
    public function get_by_category($category_id = 0, $order = 'asc', $limit = array())
    {
        $this->db->select('posts.id, posts.title, posts.link, posts.image, posts.content, posts.created_on, posts_categories.post_id, posts_categories.category_id');
        $this->db->from($this->table_name);
        $this->db->join('posts_categories', 'posts_categories.post_id = posts.id');
        $this->db->where('posts_categories.category_id', $category_id);
        $this->db->where('posts.status', '1');
        $this->db->where('posts.deleted', 0);
        $this->db->order_by('created_on', $order);
        if ((is_array($limit)) and ( count($limit) != 0)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        return $this->db->get();
    }

    /**
     * Search into title, content and tags from posts.
     *
     * @return mixed
     * @author Eliel de Paula <elieldepaula@gmail.com>
     * */
    public function busca_posts($search = null)
    {
        if ($search) {
            $this->db->like('title', $search, 'both');
            $this->db->or_like('content', $search, 'both');
            $this->db->or_like('tags', $search, 'both');
        }

        $this->db->where('status', '1');
        $this->db->order_by('created_on', 'desc');

        return $this->db->get($this->table_name);
    }

}
