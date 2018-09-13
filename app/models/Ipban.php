<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Ipban
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Ipban extends MY_Model
{

    public $table_name = 'ip_banned';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = FALSE;
    protected $log_user = FALSE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;

}

// End of file models/ipban.php