<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Module_action
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Module_action extends MY_Model
{

    /**
     * Table name.
     * @var string
     */
    public $table_name = 'modules_actions';

    /**
     * Primary key
     * @var string
     */
    public $primary_key = 'id';

    /**
     * Date time format.
     * @var string
     */
    public $date_format = 'datetime';

    /**
     * Enable soft-delete.
     * @var bool
     */
    protected $soft_deletes = FALSE;

    /**
     * Log user.
     * @var bool
     */
    protected $log_user = TRUE;

    /**
     * Set created datetime values automatically.
     * @var bool
     */
    protected $set_created = TRUE;

    /**
     * Set modified datetime values automatically.
     * @var bool
     */
    protected $set_modified = TRUE;

}
