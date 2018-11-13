<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Notifications
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Notification extends MY_Model
{
    public $table_name = 'newsnotifications';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = TRUE;
    protected $log_user = TRUE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;
    
    /**
     * Cria uma nova notificação, ignora caso já exista uma com a mesma URL.
     * 
     * @param array $data
     * @return int
     */
    public function new_notification($data)
    {
        $total = $this->count_by('url', $data['url']);
        if($total <= 0)
           return @$this->insert($data);
    }
    
}
