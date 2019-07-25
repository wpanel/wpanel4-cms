<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Este arquivo contém a configuração básica da paginação do CodeIgniter.
 */

// $config['base_url']      = site_url($base);
// $config['total_rows']    = $total_registros;
// $config['per_page']      = 10;
// $config['uri_segment']   = 5;
$config['full_tag_open']    = '<ul class="pagination">';
$config['full_tag_close']   = '</ul>';
$config['cur_tag_open']     = '<li class="active"><a>';
$config['cur_tag_close']    = '<span class="sr-only">(current)</span></a></li>';
$config['num_tag_open']     = '<li>';
$config['num_tag_close']    = '</li>';
$config['prev_tag_open']    = '<li><span aria-hidden="true">';
$config['prev_tag_close']   = '</span></li>';
$config['next_tag_open']    = '<li><span aria-hidden="true">';
$config['next_tag_close']   = '</span></li>';
$config['last_tag_open']    = '<li>';
$config['last_tag_close']   = '</li>';
$config['last_link']        = '>>';
$config['first_tag_open']   = '<li>';
$config['first_tag_close']  = '</li>';
$config['first_link']       = '<<';