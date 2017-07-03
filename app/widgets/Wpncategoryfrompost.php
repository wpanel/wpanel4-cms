<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Category from posts class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpncategoryfrompost extends Widget
{

    /**
     * Post id.
     */
    protected $post_id = '';

    /**
     * Class constructor.
     */
    function __construct($config = array())
    {
        if (count($config) > 0)
            $this->initialize($config);
    }

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $html = '';
        $this->load->model('categoria');
        $query = $this->categoria->get_by_post($this->post_id)->result();

        foreach ($query as $row)
        {
            $html .= anchor('posts/' . $row->id . '/' . $row->link, $row->title, array('class' => 'label label-warning', 'style' => 'margin-right:5px;'));
        }
        return $html;
    }

}
