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

class Configuracao extends MY_Model
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Load json config file or item.
     * 
     * @param string $conf_item
     * @return mixed
     */
    public function load_config()
    {
        $cobj = $this->wpanel->read_json(FCPATH . 'config/config.json');
        return $cobj;
    }

    /**
     * Save an config file.
     * 
     * @param mixed $data
     * @return boolean
     */
    public function save_config($data)
    {
        $json = json_encode($data);
        if($this->wpanel->write_json($data, FCPATH . 'config/config.json', $json))
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Return an config item.
     * 
     * @param string $item
     * @return mixed
     */
    public function get_config($item = null)
    {
        $object = $this->load_config();
        return $object->{$item};
    }

}
