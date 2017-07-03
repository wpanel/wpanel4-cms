<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Dash
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Dash extends MY_Model
{

    public function calcula_totais($modulo, $tipo = 0)
    {

        $this->db->where('user_id', $this->auth->get_account_id());

        if ($modulo == 'posts')
            $this->db->where('page', $tipo);

        $this->db->from($modulo);

        return $this->db->count_all_results();
    }

}
