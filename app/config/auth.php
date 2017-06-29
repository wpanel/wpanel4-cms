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

/**
 * Define os tipos de usuário serão permitidos no site. 
 */
$config['auth_account_role'] = array('ROOT'=>'Super-User', 'user' => 'Usuário comum', 'admin' => 'Administrador');

/**
 * Check permissions into a hook for all methods (global).
 */
$config['auth_check_permyssion_by_hook'] = FALSE;

/**
 * Register a log from user access.
 */
$config['auth_log_access'] = TRUE;

/**
 * Enable the bann IP's.
 */
$config['auth_enable_ip_banned'] = TRUE;

$config['auth_max_attempts'] = 10; // Define o máximo de tentativas de login.

$config['auth_enable_autoban'] = TRUE; // Bane automaticamente o IP caso atinja o limite.

/**
 * Type of hash for passwords.
 */
$config['auth_password_hash_type'] = 'md5';

/**
 * Password salt for hash.
 */
$config['auth_password_hash_salt'] = '';

/**
 * Set an white-list to free access into some links.
 */
$config['auth_white_list'] = array(
    'admin',
    'admin/login',
    'admin/dashboard',
    'admin/accounts/profile',
    // Liberado para testes
    'admin/modulos',
    'admin/modulos/add',
    'admin/modulos/edit/*',
    'admin/moduloitens/add/*',
    'admin/moduloitens/edit/*/*',
    'admin/accounts/activate/*',
    'admin/accounts/deactivate/*',
    /*'admin/configuracoes',
    'admin/configuracoes/index',
    'gerador',
    'gerador/main',
    'gerador/main/gerarModel',
    'gerador/main/gerarController',
    'gerador/main/gerarCrud',*/
);
