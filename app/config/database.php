<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$active_group  = ENVIRONMENT;
$query_builder = TRUE;

/**
 * Configurações para o ambiente de desenvolvimento.
 */
 
// Descomente para usar MySQL
// $db['development']['hostname'] = 'localhost';
// $db['development']['username'] = 'elieldepaula';
// $db['development']['password'] = '';
// $db['development']['database'] = 'c9';
// $db['development']['dbdriver'] = 'mysqli';

// Implementação usando SQLite.
$db['development']['hostname'] = 'sqlite:'.APPPATH.'db/wpanel.sqlite';
$db['development']['username'] = '';
$db['development']['password'] = '';
$db['development']['database'] = '';
$db['development']['dbdriver'] = 'pdo';

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
$db['production']['dbdriver'] = 'mysqli';
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
