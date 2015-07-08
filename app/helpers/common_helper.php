<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/*
 *-----------------------------------------------
 * Exibe um menu
 *-----------------------------------------------
 */
if (!function_exists('wpn_get_menu'))
{
	function wpn_get_menu($menu_id = null, $class_menu = null, $class_item = null)
	{
		$CI =& get_instance();
		return $CI->wpanel->get_menu($menu_id, $class_menu, $class_item);
	}
}

/*
 *-----------------------------------------------
 * Retorna os banners de uma posição
 *-----------------------------------------------
 */
if (!function_exists('wpn_banners'))
{
	function wpn_banners($position)
	{
		$CI =& get_instance();
		$CI->load->model('banner');
        return $CI->banner->get_banners($position)->result();
	}
}
