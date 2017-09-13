<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe Wpneventsmenu
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpneventsmenu extends Widget
{

    protected $attributes = '';

    /**
     * Class constructor.
     * @param mixed $config
     */
    function __construct($config = array())
    {
        if (count($config) > 0)
        {
            $this->initialize($config);
        }
    }

    /**
     * Set an array of html attributes to the output.
     * 
     * @param mixed $attributes
     * @return string
     */
    private function _attributes($attributes)
    {
        if (is_array($attributes))
        {
            $atr = '';
            foreach ($attributes as $key => $value)
            {
                $atr .= $key . "=\"" . $value . "\" ";
            }
            return $atr;
        } elseif (is_string($attributes) and strlen($attributes) > 0)
        {
            $atr = ' ' . $attributes;
        }
    }

    /**
     * Main method of the widget.
     * 
     * @return string
     */
    public function main()
    {
        $this->load->model('post');
        $query = $this->post
                ->select('title, description, link, created_on')
                ->order_by('created_on', 'desc')
                ->find_many_by(array('page' => '2', 'status' => '1'));
        $html = '';
        $html .= '<ul ' . $this->_attributes($this->attributes) . '>';
        foreach ($query as $key => $row)
        {
            $html .= '<li>' . anchor('event/' . $row->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $row->title) . '<br/><small>' . $row->description . '</small><br/><small>' . date('d/m/Y', strtotime($row->created_on)) . '</small></li>';
        }
        $html .= '</ul>';
        return $html;
    }

}
