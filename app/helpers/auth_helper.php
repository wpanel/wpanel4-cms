<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('auth_extra_data'))
{

    /**
     * This helper return a 'extra-data' item from the session login.
     *
     * @param $var string
     * @return mixed
     */
    function auth_extra_data($var = null)
    {
        $CI =& get_instance();
        if($var == null)
            return $CI->auth->get_extra_data();
        else
            return $CI->auth->get_extra_data($var);

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