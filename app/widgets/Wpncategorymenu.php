<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Category menu class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpncategorymenu extends Widget
{

    protected $inicial_id = '0';
    protected $main_attr = '';
    protected $item_attr = '';

    function __construct($config = array())
    {
        if (count($config) > 0)
            $this->initialize($config);
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
     * @return mixed
     */
    public function main()
    {
        return $this->get_category($this->inicial_id);
    }

    /**
     * Get the category list by $id
     * 
     * @param int $id
     * @return string
     */
    private function get_category($id)
    {

        $this->load->model('category');
        $query = $this->category
                ->select('id, title, link')
                ->order_by('title', 'asc')
                ->find_many_by('category_id', $id);

        $html = '';
        $html .= '<ul ' . $this->_attributes($this->main_attr) . '>';
        foreach ($query as $row)
        {
            $html .= '<li ' . $this->_attributes($this->item_attr) . '>' . anchor('/posts/' . $row->id . '/' . $row->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $row->title) . '</li>';
            $html .= $this->get_category($row->id);
        }
        $html .= '</ul>';

        return $html;
    }

}
