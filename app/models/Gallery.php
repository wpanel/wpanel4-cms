<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Gallery
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Gallery extends MY_Model
{

    public $table_name = 'albuns';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = TRUE;
    protected $log_user = TRUE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;

}
