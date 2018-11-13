<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Ipallowed
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Ipallowed extends MY_Model
{

    public $table_name = 'ip_alloweds';
    public $primary_key = 'id';
    public $date_format = 'datetime';
    protected $soft_deletes = FALSE;
    protected $log_user = FALSE;
    protected $set_created = TRUE;
    protected $set_modified = TRUE;
    
    /**
     * Este método retorna se um IP está ou não na lista branca. Os IPs desta
     * lista serão ignordos no momento de verificar IPs banidos no login.
     * 
     * @param string $ip_address
     * @return boolean
     */
    public function is_whitelisted($ip_address)
    {
        if($this->count_by('ip_address', $ip_address) === 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
}
