<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/*
|--------------------------------------------------------------------------
| Este helper contém as funções utilitárias específicas do wPanel.
|
| Foi desenvolvido para ser usado no FrameWork CodeIgniter em conjunto
| com o helper HTML e URL e Bootstrap-Helper.
|
| @author Eliel de Paula <elieldepaula@gmail.com>
| @since 21/10/2014
|--------------------------------------------------------------------------
 */

if (!function_exists('status_post')) {

	function status_post($status) {
		if ($status == '1') {
			return '<span class="label label-success">Publicado</span>';
		} else {
			return '<span class="label label-danger">Indisponível</span>';
		}
	}

}

if (!function_exists('status_user')) {

	function status_user($status) {
		if ($status == '1') {
			return '<span class="label label-success">Ativo</span>';
		} else {
			return '<span class="label label-danger">Bloqueado</span>';
		}
	}

}