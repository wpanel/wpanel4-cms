<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main menu class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnmainmenu extends Widget
{

    protected $menu_id = '';
    protected $ul_style = '';
    protected $li_style = '';
    protected $ul_dropdown = '';

    /**
     * Class constructor.
     * 
     * @param mixed $config
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
        return $this->get_menu($this->menu_id, $this->ul_style, $this->li_style);
    }

    /**
     * This method shows an HTML from menu by $id
     * 
     * @param int $menu_id
     * @param string $ul_style
     * @param string $li_style
     * @return mixed
     */
    private function get_menu($menu_id = null, $ul_style = '', $li_style = '')
    {
        if ($menu_id == null)
            return false;

        $this->load->model('menu_item');
        $query = $this->menu_item
                ->select('href, label, tipo')
                ->order_by('ordem', 'asc')
                ->find_many_by('menu_id', $menu_id);

        $html = "";
        $html .= "<ul class=\"" . $ul_style . "\">";
        foreach ($query as $row)
        {

            if ($row->tipo == 'submenu')
                $html .= "<li class=\"" . $li_style . "\">";
            else
                $html .= "<li>";

            switch ($row->tipo)
            {
                case 'link':
                    $html .= "<a href=\"" . $row->href . "\">" . $row->label . "</a>";
                    break;
                case 'post':
                    $html .= anchor('post/' . $row->href, $row->label);
                    break;
                case 'posts':
                    $html .= anchor('posts/' . $row->href, $row->label);
                    break;
                case 'funcional':
                    if ($row->href == 'home')
                        $html .= anchor('', $row->label);
                    else
                        $html .= anchor($row->href, $row->label);
                    break;
                case 'submenu':
                    $html .= "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\"  data-submenu>" . $row->label . " <span class=\"caret\"></span></a>";
                    $html .= $this->get_menu($row->href, 'dropdown-menu', 'dropdown-submenu');
                    break;
            }
            $html .= "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

}
