<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$active_group = ENVIRONMENT;
$active_record = TRUE;

/**
 * Configurações para o ambiente de desenvolvimento.
 */
$db['development']['hostname'] = 'localhost';
$db['development']['username'] = 'root';
$db['development']['password'] = 'root';
$db['development']['database'] = 'wpanel_dev';
$db['development']['dbdriver'] = 'mysql';
$db['development']['dbprefix'] = '';
$db['development']['pconnect'] = TRUE;
$db['development']['db_debug'] = TRUE;
$db['development']['cache_on'] = FALSE;
$db['development']['cachedir'] = '';
$db['development']['char_set'] = 'utf8';
$db['development']['dbcollat'] = 'utf8_general_ci';
$db['development']['swap_pre'] = '';
$db['development']['autoinit'] = TRUE;
$db['development']['stricton'] = FALSE;

/**
 * Configurações para o ambiente de produção.
 */
$db['production']['hostname'] = '';
$db['production']['username'] = '';
$db['production']['password'] = '';
$db['production']['database'] = '';
$db['production']['dbdriver'] = 'mysql';
$db['production']['dbprefix'] = '';
$db['production']['pconnect'] = TRUE;
$db['production']['db_debug'] = TRUE;
$db['production']['cache_on'] = FALSE;
$db['production']['cachedir'] = '';
$db['production']['char_set'] = 'utf8';
$db['production']['dbcollat'] = 'utf8_general_ci';
$db['production']['swap_pre'] = '';
$db['production']['autoinit'] = TRUE;
$db['production']['stricton'] = FALSE;

