<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Wpanel CMS general helper.
 *
 * This helper contains the common functions to Wpanel CMS.
 * 
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
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
        $CI = & get_instance();
        $theme = $CI->config->item('template');

        switch ($type)
        {
            case 'css':
                return "<link href=\"" . base_url( 'themes/' . $theme . '/css/' . $filename) . "\" rel=\"stylesheet\">\n";
                break;
            case 'js':
                return "<script src=\"" . base_url('themes/' . $theme . '/js/' . $filename) . "\" type=\"text/javascript\"></script>\n";
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
            return '<span class="label label-success">' . wpn_lang('wpn_published') . '</span>';
        else
            return '<span class="label label-danger">' . wpn_lang('wpn_unpublished') . '</span>';
    }

}

if (!function_exists('status_notification'))
{

    /**
     * Return a bootstrap label tag according to the notification status.
     *
     * @param $status int Notification status.
     * @return string
     * */
    function status_notification($status)
    {
        if ($status == '1')
            return '<span class="label label-success">Lido</span>';
        else
            return '<span class="label label-info">Não lido</span>';
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

if (!function_exists('status_label'))
{

    /**
     * Return a bootstrap label tag according to the user status.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $status int - User status
     * @return string
     * */
    function status_label($status)
    {
        if ($status == '1') {
            return '<span class="label label-success">' . wpn_lang('wpn_active') . '</span>';
        }
        return '<span class="label label-danger">' . wpn_lang('wpn_inactive') . '</span>';
    }

}

if (!function_exists('wpn_lang'))
{

    /**
     * Return a language key.
     *
     * @param string $key Key
     * @param string $file Language file name
     * @return string
     */
    function wpn_lang($key, $file = null)
    {
        $CI = & get_instance();
        $lang = wpn_config('language');
        if ($file)
            $CI->lang->load($file, $lang);
        $line = $CI->lang->line($key, false);
        if ($line)
            return $line;
        else
            return "[$key]";
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
