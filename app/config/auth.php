<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Configurações da biblioteca Auth()
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 01/10/2014
 */

$config['auth_table_name']		= 'users';
$config['auth_table_key']		= 'id';
$config['auth_username_field']	= 'email';
$config['auth_password_field']	= 'password';
$config['auth_login_redirect']	= '/admin';
$config['auth_logout_redirect']	= '/admin/login';
$config['auth_msg_erro_login']	= 'Você precisa logar para acessar.';
$config['auth_msg_erro_fail']	= 'Seu login falhou, tente novamente.';
$config['auth_msg_erro_role']	= 'Você não tem permissão para acessar esta área.';