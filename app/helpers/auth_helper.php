<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
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
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
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
    /**
     * Verifica se um usuário tem permissão para determinado link. A opção $override_root
     * serve para não considerar o root na hora da checagem.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param String $url Link da pagina Eg. 'admin/users'
     * @param Integer $account_id ID da conta a ser testada. Caso seja null usa-se o usuário logado.
     * @param Bool $override_root Ignora o ROOT na verificação.
     * @return Mixed
     */
    function has_permission($url, $account_id = NULL, $override_root = FALSE)
    {
        $CI =& get_instance();
        return $CI->auth->has_permission($url, $account_id, $override_root);
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