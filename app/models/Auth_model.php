<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
	}

	//TODO Criar os métodos da biblioteca Auth() aqui.

	// Cria uma nova conta.
	public function insert_account($data)
	{
		$this->db->insert('accounts', $data);
		return $this->db->insert_id();
	}

	// Atualiza uma conta
	public function update_account($data)
	{
		$id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);
		$this->db->update('accounts', $data);
		return $this->db->affected_rows();
	}

	// Verifica se o email já existe.
	public function email_exists($email)
	{
		$this->db->select('id');
		$this->db->where('email', $email);
		$num = $this->db->get('accounts')->num_rows();
		return ($num > 0);
	}

}