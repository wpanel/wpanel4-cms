<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
    'admin/dashboard',
    'admin/accounts/profile',
    // Liberado para testes
    'admin/accounts',
    'admin/accounts/add',
    'admin/accounts/edit',
    'admin/accounts/edit/*',
    'admin/accounts/delete',
    'admin/configuracoes',
    'admin/configuracoes/index'
);
