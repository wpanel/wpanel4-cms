<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Define os tipos de usuário serão permitidos no site. 
 */
$config['auth_account_role'] = array('ROOT'=>'Super-User', 'user' => 'Usuário comum', 'admin' => 'Administrador');

/**
 * Check permissions into a hook for all methods (global).
 */
$config['auth_check_permyssion_by_hook'] = FALSE;

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
    // 'admin/accounts',
    // 'admin/accounts/add',
    // 'admin/accounts/edit',
    // 'admin/accounts/edit/*',
    // 'admin/accounts/changepassword/*',
    // 'admin/accounts/delete/*',
    'admin/configuracoes',
    'admin/configuracoes/index',
    'gerador',
    'gerador/main',
    'gerador/main/gerarModel',
    'gerador/main/gerarController',
    'gerador/main/gerarCrud',
);
