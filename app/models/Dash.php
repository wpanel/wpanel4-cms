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

    /**
     * Este método retorna os totais de cada conteúdo para exibição
     * na dashboard do usuário.
     * 
     * @param string $modulo
     * @param string $tipo
     * @return int
     */
    public function calcula_totais($modulo, $tipo = 0)
    {
        $wheres = array();
        $wheres['user_id'] = $this->auth->get_account_id();
        if ($modulo == 'posts')$wheres['page'] = $tipo;
        return $this->count_by($wheres);
    }

}
