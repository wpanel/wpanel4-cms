<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends MY_Model {

	public $table_name = 'users';
	public $primary_key = 'id';

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function inicial_user()
	{
		if ($this->db->count_all_results($this->table_name) >= 1) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}