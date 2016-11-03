<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_logged'))
{
    // Retorna se está ou não logado.
    function is_logged()
    {
        $CI =& get_instance();
        if($CI->session->userdata('logged_in'))
            return TRUE;
        else
            return FALSE;
    }
}

if (!function_exists('has_permission'))
{
    // Verifica se tem permissão em um determinado link.
    function has_permission($url, $account_id = NULL)
    {
        $CI =& get_instance();
        return $CI->auth->has_permission($url, $account_id);
    }
}

if (!function_exists('auth_extra_data'))
{
    /**
     * This helper return a 'extra-data' item from the session login.
     *
     * @param $item string
     * @return mixed
     */
    function auth_extra_data($item = null, $json = null)
    {
        $CI =& get_instance();
        if($item == null)
            return $CI->auth->get_extra_data(null, $json);
        else
            return $CI->auth->get_extra_data($item, $json);
    }
}

if (!function_exists('auth_login_data'))
{
    /**
     * This helper return a item from the session login.
     *
     * @param $var string
     * @return mixed
     */
    function auth_login_data($var)
    {
        $CI =& get_instance();
        return $CI->auth->get_login_data($var);
    }
}