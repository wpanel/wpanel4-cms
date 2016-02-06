<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dash extends MY_Model {

	public function calcula_totais($modulo, $tipo = 0)
	{

		$this->db->where('user_id', $this->wpanel->get_from_user('id'));

		if($modulo == 'posts')
			$this->db->where('page', $tipo);
		
		$this->db->from($modulo);

		return $this->db->count_all_results();

	}

}