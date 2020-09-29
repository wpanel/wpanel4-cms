<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Slide banner class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnslidebanner extends Widget
{

    protected $position = '';
    protected $class_name = '';
    protected $interval = '5000';
    protected $cycle = 'true';

    function __construct($config = array())
    {
        if (count($config) > 0) {
            $this->initialize($config);
        }
    }

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $this->load->model('banner');
        $query = $this->banner
                ->select('content, href, target')
                ->order_by('sequence', 'asc')
                ->find_many_by(array('position' => $this->position, 'status' => 1));
        if (count($query) > 0) {
            $data = array(
                'banners' => $query,
                'class_name' => $this->class_name
            );
            $this->view('slidebanner', $data);
        }
    }
}
