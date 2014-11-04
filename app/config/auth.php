<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| Auth configuration file for CodeIgnniter, put him into /application/config
*/

$config['auth_table_name']		= 'users';
$config['auth_table_key']		= 'id';
$config['auth_username_field']	= 'email';
$config['auth_password_field']	= 'password';
$config['auth_login_redirect']	= '/admin/dashboard';
$config['auth_logout_redirect']	= '/admin/dashboard/login';
$config['auth_msg_erro_login']	= 'Você precisa logar para acessar.';
$config['auth_msg_erro_fail']	= 'Seu login falhou, tente novamente.';
$config['auth_msg_erro_role']	= 'Você não tem permissão para acessar esta área.';

