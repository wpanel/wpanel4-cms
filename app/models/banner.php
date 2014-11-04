<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class banner extends MY_Model {

	public $table_name = 'banners';
	public $primary_key = 'id';

	/**
	 * Este método retorna uma lista de banners de acordo
	 * com a $posicao indicada. Caso nenhuma posição seja
	 * informada, ele retornará a lista completa.
	 *
	 * @return void
	 * @param $posicao String Posição do banner.
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function get_banners($posicao = '') {
		if ($posicao) {
			$this->db->where('position', $posicao);
			$this->db->where('status', '1');
		} else {
			$this->db->where('status', '1');
		}
		return $this->db->get('banners');
	}
}
