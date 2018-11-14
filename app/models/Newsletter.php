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

    /**
     * Create a new lead.
     * 
     * @param array $data Array com os dados do lead.
     */
    public function create_lead($data = array())
    {
    	$total = $this->count_by('email', $data['email']);
    	if ($total == 0){
    		$data['ipaddress'] = $this->input->server('REMOTE_ADDR', true);
    		return $this->insert($data);
    	}
    }

}

// END class
