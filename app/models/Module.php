<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Module
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Module extends MY_Model
{

    /**
     * Table name.
     * @var string
     */
    public $table_name = 'modules';

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

    /**
     * White list of modules.
     */
    const WHITE_LIST = [
        '',
        'dashboard'
    ];

    /**
     * Sistem modules.
     */
    const SYSTEM_MODULES = [
        'gerenciador-de-menus',
        'gerenciador-de-leads',
        'contas-de-usuarios',
        'configuracoes',
        'notificacoes'
    ];

    /**
     * Check if the module is active.
     *
     * @param string $name_id
     * @return bool|INT
     */
    public function is_active($name_id = null)
    {
        if (in_array($name_id, self::WHITE_LIST)) {
            return true;
        }
        return $this->count_by(['name_id' => $name_id, 'status' => 1]);
    }

}
