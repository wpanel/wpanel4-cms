<?php

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class imovel extends MY_Model {

	public $table_name = 'imoveis';
	public $primary_key = 'id';

	/**
	 * Este método faz a listagem dos últimos imóveis na página inicial
	 * do site.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function ultimos_imoveis($offset, $limit) {
		$this->db->where('status', 1);
		return $this->db->get($this->table_name, $limit, $offset);
	}

	/**
	 * Este método faz a pesquisa de imíveis na base de dados
	 * de acordo com o os parametros enviados.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function buscar_imovel($options = array()) {
		foreach ($options as $key => $value) {
			if (is_array($value))// in case of between queries...
			{
				$this->db->where($key . ' BETWEEN ' . $value[0] . ' AND ' . $value[1]);// TIP from stackoverflow.com: $this->db->where("$accommodation BETWEEN $minvalue AND $maxvalue");
			} else {
				$this->db->like($key, $value, 'both');
			}
		}
		return $this->db->get($this->table_name);
	}
}