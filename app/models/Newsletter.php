<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Newsletter
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Newsletter extends MY_Model
{

    protected $table_name = 'newsletter_email';
    protected $primary_key = 'id';
    protected $date_format = 'datetime';
    protected $soft_deletes = false;
    protected $log_user = false;
    protected $set_created = TRUE;
    protected $set_modified = false;

}

// END class
