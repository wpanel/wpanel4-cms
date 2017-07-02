<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main menu class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
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
        $query = $this->menu_item->order_by('ordem', 'asc')->find_many_by('menu_id', $menu_id);

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
