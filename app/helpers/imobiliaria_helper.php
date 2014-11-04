<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_imagem_imovel'))
{
	/*
	| Busca uma imagem de um imóvel para a capa.
	*/
	function get_imagem_imovel($id)
	{
		$CI =& get_instance();
		$CI->load->model('fotos_imoveis');
		$query = $CI->fotos_imoveis->get_by_field('imovel_id', $id)->row();
		return $query->file;
	}
}