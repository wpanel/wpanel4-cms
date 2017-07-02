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
 * Wpanel CMS general helper.
 *
 * This helper contains the common functions to Wpanel CMS.
 *
 * @package     WpanelCms
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        http://elieldepaula.com.br
 * @since       v1.0.0
 */
if (!function_exists('wpn_asset'))
{

    /**
     * Get the include code for assets: CSS or JavaScript.
     *
     * @param $type string Type of library, CSS, JS or Custom.
     * @param $filename string File name to be included.
     * @return String
     */
    function wpn_asset($type, $filename)
    {
        switch ($type)
        {
            case 'css':
                return "<link href=\"" . base_url('assets/css/' . $filename) . "\" rel=\"stylesheet\">\n";
                break;
            case 'js':
                return "<script src=\"" . base_url('assets/js/' . $filename) . "\" type=\"text/javascript\"></script>\n";
                break;
            case 'custom':
                return $filename;
                break;
        }
    }

}

if (!function_exists('wpn_config'))
{

    /**
     * Return a config item or all the object from config.json.
     *
     * @param $item mixed Config item.
     * @return mixed
     */
    function wpn_config($item = null)
    {
        $CI = & get_instance();
        return $CI->wpanel->get_config($item);
    }

}

if (!function_exists('wpn_meta'))
{

    /**
     * Return a full Meta-Tag to header of the site.
     *
     * @return mixed
     */
    function wpn_meta()
    {
        $CI = & get_instance();
        return $CI->wpanel->get_meta();
    }

}

if (!function_exists('wpn_fakelink'))
{

    /**
     * This produces a link based on the string $var
     *
     * @return string
     */
    function wpn_fakelink($var)
    {
        return strtolower(url_title(convert_accented_characters($var)));
    }

}

if (!function_exists('wpn_activelink'))
{

    /**
     * Return class="active" to bootstrap menu.
     *
     * @param $link mixed Link param to check, It could be string or array.
     * @param $segment integer Segment of the URL to be checked, default 2 to Control Panel.
     * @param $return string Code returned case is active, default: class="active".
     * @return string
     */
    function wpn_activelink($link, $segment = 2, $return = ' class="active"')
    {
        $CI = & get_instance();
        $var = $CI->uri->segment($segment);
        if (is_array($link))
            if (in_array($var, $link))
                return $return;
            else
                return '';
        else
        if ($var == $link)
            return $return;
        else
            return '';
    }

}

if (!function_exists('status_post'))
{

    /**
     * Return a bootstrap label tag according to the post status.
     *
     * @param $status int Post status.
     * @return string
     * */
    function status_post($status)
    {
        if ($status == '1')
            return '<span class="label label-success">Publicado</span>';
        else
            return '<span class="label label-danger">Indisponível</span>';
    }

}

if (!function_exists('sim_nao'))
{

    /**
     * Return a bootstrap label tag according to the user status.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $status int - User status
     * @return string
     * */
    function sim_nao($status)
    {
        if ($status == '1')
            return '<span class="label label-success">Sim</span>';
        else
            return '<span class="label label-danger">Não</span>';
    }

}

if (!function_exists('status_user'))
{

    /**
     * Return a bootstrap label tag according to the user status.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $status int - User status
     * @return string
     * */
    function status_user($status)
    {
        if ($status == '1')
            return '<span class="label label-success">Ativo</span>';
        else
            return '<span class="label label-danger">Bloqueado</span>';
    }

}

if (!function_exists('wpn_lang'))
{

    /**
     * Return a language key.
     *
     * @param string $key Key
     * @param string $default default value
     * @param string $file Language file name
     * @return string
     */
    function wpn_lang($key, $default, $file = 'wpn_common')
    {
        $CI = & get_instance();
        $lang = wpn_config('language');
        if (isset($file))
            $CI->lang->load($file, $lang);
        $line = $CI->lang->line($key, false);
        if ($line)
            return $line;
        else
            return $default;
    }

}

if (!function_exists('formata_money'))
{

    /**
     * Format numbers at monetary values.
     *
     * @param $var double Valor a ser convertido.
     * @param $format string Formato do retorno.
     * @return mixed
     */
    function formata_money($var, $format = 'br')
    {
        if ($format == 'br')
            return number_format($var, 2, ',', '.');
        else if ($format == 'us')
            return str_replace(',', '.', str_replace('.', '', $var));
    }

}
