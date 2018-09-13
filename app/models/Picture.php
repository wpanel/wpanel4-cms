<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Picture
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Picture extends MY_Model
{

    public $table_name = 'fotos';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = TRUE;
    protected $log_user = TRUE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;

    /**
     * This method removes all images and directory from an album.
     * 
     * @param int $album_id
     * @return mixed
     */
    public function delete_by_album($album_id)
    {
        $query = $this->find_many_by('album_id', $album_id);
        foreach ($query as $row)
        {
            $this->wpanel->remove_media('albuns/' . $album_id . '/' . $row->filename);
        }
        @rmdir(FCPATH . 'media/albuns/' . $album_id);
        return $this->delete($album_id);
    }

}
