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
 * Category menu class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
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

        $this->load->model('categoria');
        $query = $this->categoria->order_by('title', 'asc')->find_many_by('category_id', $id);

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
