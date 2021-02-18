<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

class Wpnfooterbanner extends Widget
{

    const POSITION = 'footer';

    function __construct($config = array())
    {
        if (isset($config)) {
            $this->initialize($config);
        }
    }

    public function main()
    {
        $this->load->model('banner');
        $query = $this->banner
            ->select('content, href, target')
            ->order_by('sequence', 'asc')
            ->find_many_by(array('position' => self::POSITION, 'status' => 1));
        if ($query) {
            $data = array(
                'banners' => $query
            );
            $this->view('footerbanner', $data);
        }
    }
}