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
define('EXT', '.php');

/**
 * Esta classe provê os métodos para o funcionamento do mecanismo de Widget usado
 * no WpanelCMS.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v.1.0.0
 */
class Widget
{

    function __get($var)
    {
        global $CI;
        return $CI->$var;
    }

    /**
     * Initialize the params to the widget.
     * 
     * @param array $params
     * @return $this
     */
    public function initialize($params = array())
    {
        foreach ($params as $key => $val)
        {
            if (isset($this->$key))
            {
                $method = 'set_' . $key;
                if (method_exists($this, $method))
                    $this->$method($val);
                else
                    $this->$key = $val;
            }
        }
        return $this;
    }

    /**
     * Load an widget file.
     * 
     * @param string $file
     * @param array $param
     * @return mixed
     */
    public function load($file, $param = null)
    {
        //print_r($file);
        $module = '';
        if (($pos = strrpos($file, '/')) !== FALSE)
        {
            $module = substr($file, 0, $pos);
            $file = substr($file, $pos + 1);
        }

        list($path, $file) = $this->_find($file, $module, 'widgets/');

        if ($path === FALSE)
            $path = APPPATH . 'widgets/';

        $file = ucfirst($file);

        $this->_load_file($file, $path);

        $widget = new $file($param);
        return $widget->main();
    }

    /**
     * Find some file into the folders.
     * 
     * @param String $file
     * @param String $module
     * @param String $base
     * @return Mixed
     */
    private function _find($file, $module, $base)
    {
        $segments = explode('/', $file);

        $file = array_pop($segments);
        $file_ext = (pathinfo($file, PATHINFO_EXTENSION)) ? $file : $file . EXT;

        $path = ltrim(implode('/', $segments) . '/', '/');
        $module ? $modules[$module] = $path : $modules = array();

        if (!empty($segments))
        {
            $modules[array_shift($segments)] = ltrim(implode('/', $segments) . '/', '/');
        }

        foreach (array(APPPATH . 'modules/' => '../modules/') as $location => $offset)
        {
            foreach ($modules as $module => $subpath)
            {
                $fullpath = $location . $module . '/' . $base . $subpath;
                if ($base == 'libraries/' OR $base == 'models/')
                {
                    if (is_file($fullpath . ucfirst($file_ext)))
                        return array($fullpath, ucfirst($file));
                }
                else
                /* load non-class files */
                if (is_file($fullpath . $file_ext))
                    return array($fullpath, $file);
            }
        }
        return array(FALSE, $file);
    }

    /**
     * Load some file.
     * 
     * @param string $file
     * @param string $path
     * @param string $type
     * @param bool $result
     * @return mixed
     */
    private function _load_file($file, $path, $type = 'other', $result = TRUE)
    {
        $file = str_replace(EXT, '', $file);
        $location = $path . $file . EXT;
        if ($type === 'other')
        {
            if (class_exists($file, FALSE))
            {
                log_message('debug', "File already loaded: {$location}");
                return $result;
            }
            include_once $location;
        } else
        {
            /* load config or language array */
            include $location;

            if (!isset($$type) OR ! is_array($$type))
                show_error("{$location} does not contain a valid {$type} array");

            $result = $$type;
        }
        log_message('debug', "File loaded: {$location}");
        return $result;
    }

}
