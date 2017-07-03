<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Post_categoria
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Post_categoria extends MY_Model
{

    public $table_name = 'posts_categories';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = false;
    protected $log_user = false;
    protected $set_created = false;
    protected $set_modified = false;

    /**
     * Delete rows by post_id.
     * 
     * @param int $id_post
     * @return mixed
     */
    public function delete_by_post($id_post)
    {
        $this->db->where('post_id', $id_post);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

}
