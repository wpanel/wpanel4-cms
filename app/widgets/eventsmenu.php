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

class Eventsmenu extends Widget
{

    private $attributes = '';

    function __construct($config = array())
    {
        if (count($config) > 0)
        {
            $this->initialize($config);
        }
    }

    public function initialize($config = array())
    {
        foreach ($config as $key => $val)
        {
            if (isset($this->$key))
            {
                $method = 'set_' . $key;
                if (method_exists($this, $method))
                {
                    $this->$method($val);
                } else
                {
                    $this->$key = $val;
                }
            }
        }
        return $this;
    }

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

    public function run()
    {
        return $this->get_menu();
    }

    private function get_menu()
    {
        $this->load->model('post');
        $query = $this->post->get_by_field(
                array('page' => '2', 'status' => '1'), null, array('field' => 'created', 'order' => 'desc'), null, 'title, link, description, created'
        );
        $html = '';
        $html .= '<ul ' . $this->_attributes($this->attributes) . '>';
        foreach ($query->result() as $key => $row)
        {
            $html .= '<li>' . anchor('event/' . $row->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $row->title) . '<br/><small>' . $row->description . '</small><br/><small>' . date('d/m/Y', strtotime($row->created)) . '</small></li>';
        }
        $html .= '</ul>';
        return $html;
    }

}
