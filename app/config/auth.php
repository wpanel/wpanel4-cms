<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Define os tipos de usuário serão permitidos no site. 
 */
$config['auth_account_role'] = array('ROOT'=>'Desenvolvedor', 'user' => 'Usuário comum', 'admin' => 'Administrador');

/**
 * Verifica as permissões em todos os links com Hook (global).
 */
$config['auth_check_permyssion_by_hook'] = FALSE;

/**
 * Registra os acessos do usuário.
 */
$config['auth_log_access'] = TRUE;

/**
 * Ativa o banimento de IPs.
 */
$config['auth_enable_ip_banned'] = TRUE;

/**
 * Define o máximo de tentativas de login antes de banir o IP.
 */
$config['auth_max_attempts'] = 10;

/**
 * Ativa o banimento automático caso o limite de tentativas seja atingido.
 */
$config['auth_enable_autoban'] = TRUE;

/**
 * Define o tipo de hash para a senha.
 * 
 * php (recomendado) - Utiliza as classes nativas do PHP.
 * sha512 - Cria o hash das senhas usando sha512.
 * md5 - Cria o hash das senhas usando MD5.
 */
$config['auth_password_hash_type'] = 'php';

/**
 * Define um SALT para o hash da senha.
 */
$config['auth_password_hash_salt'] = '';

/**
 * Define uma lista-branca de acesso para alguns links.
 */
$config['auth_white_list'] = array(
    'admin',
    'admin/login',
    'admin/dashboard',
    'admin/accounts/profile',
    'admin/accounts/changeprofilepassword'
);
