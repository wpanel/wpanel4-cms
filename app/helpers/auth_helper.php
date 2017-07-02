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
 * This helper file contains some functions to use with Auth library.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
 */

if (!function_exists('is_logged')) {
    /**
     * Check if user is logged.
     */
    function is_logged()
    {
        $CI = & get_instance();
        $CI->auth->is_logged();
    }
}

if (!function_exists('is_user')) {
    /**
     * Check if user is logged as user.
     */
    function is_user()
    {
        $CI = & get_instance();
        $CI->auth->is_user();
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if user is logged as admin.
     */
    function is_admin()
    {
        $CI = & get_instance();
        $CI->auth->is_admin();
    }
}

if (!function_exists('is_root')) {
    /**
     * Check if user is logged as root.
     */
    function is_root()
    {
        $CI = & get_instance();
        $CI->auth->is_root();
    }
}

if (!function_exists('auth_has_permission')) {

    /**
     * Check if an account have permissin to the link. Use $override_root to
     * ignore ROOT.
     *
     * @param String $url
     * @param Integer $account_id
     * @param Bool $override_root
     * @return Mixed
     */
    function auth_has_permission($url, $account_id = NULL, $override_root = FALSE)
    {
        $CI = & get_instance();
        return $CI->auth->link_permission($url, $account_id, $override_root);
    }
}

if (!function_exists('auth_extra_data')) {

    /**
     * This helper return a 'extra_data' item from the login session.
     *
     * @param $item string
     * @return mixed
     */
    function auth_extra_data($item = NULL)
    {
        $json = auth_login_data('extra_data');
        if($item == NULL)
            return $json;
        else
            return $json->$item;
    }
}

if (!function_exists('auth_login_data')) {

    /**
     * Retorna um item de uma sessão de login.
     *
     * @param $var string
     * @return mixed
     */
    function auth_login_data($var = NULL)
    {
        $CI = & get_instance();

        if ($var == NULL)
            return FALSE;
        else
            return $CI->session->userdata($var);
    }
}

if(!function_exists('auth_link_permission'))
{

    /**
    * Verifica se o usuário logado tem permissão para determinado link.
    *
    * @param $url string Link para teste, ex: admin/posts
    * @return mixed
    */
    function auth_link_permission($url = NULL, $account_id = NULL, $override_root = FALSE)
    {
        $CI =& get_instance();
        if($CI->auth->link_permission($url, $account_id, $override_root))
            return TRUE;
        else
            return FALSE;
    }
}
