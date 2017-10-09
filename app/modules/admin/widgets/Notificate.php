<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe Notificate.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Notificate extends Widget
{

    /**
     * Método principal do widget.
     * 
     * @return string
     */
    public function main()
    {
        $this->get_notifications();
    }
    
    /**
     * Monta a lista de notificações.
     */
    private function get_notifications()
    {
        $this->load->model('notification');
        $query = $this->notification->find_many_by('status', 0);
        $this->load->view('widgets/notificate', array('query' => $query));
    }

}
