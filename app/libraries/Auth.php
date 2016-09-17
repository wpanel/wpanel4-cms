<?php 

/**
* Nova biblioteca de autenticação com ACL.
*
* Esta versão tem como objetivo:
* - gerenciar os usua´rios (crud)
* - gerenciar a ativação/desativação
* - gerenciar os IP´s banidos
* - fazer o login e logout do usuário
* - registrar os logins realizados
* - limitar o acesso por excesso de tentativas
* - lembrar login (remember me) com cookies
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

	// Construtor
	public function __construct($config = array()) 
	{
		if (count($config) > 0) 
		{
			$this->initialize($config);
		}
		$this->load->model('auth_model', 'model');
		log_message('debug', "Auth Class Initialized");
	}

	// Permite que use a instância do CI
	public function __get($var) 
	{
		return get_instance()->$var;
	}

//----------------------------------------------------------------
//	Métodos da API
//----------------------------------------------------------------

	public function create_account($email, $password, $role, $profile_data = array())
	{
		return $this->_create_account($email, $password, $role, $profile_data);
	}

	public function activate_account()
	{
		//TODO Criar o método que ativa o usuário pelo email (token).
	}

	public function deactivate_account()
	{
		//TODO Criar o método que desativa um usuário.
	}

	public function update_account()
	{
		//TODO Criar o método que edita o usuário.
	}

	public function login($email, $password, $remember = FALSE, $backlink = NULL)
	{
		return $this->_login_account($email, $password, $remember, $backlink);
	}

	public function logout()
	{
		return $this->_logout_account();
	}

	public function has_permission()
	{
		//TODO Criar o método que verifica se tem permissão.
	}

	public function get_account_id()
	{
		//TODO Retornar o ID da conta logada.
	}

	public function get_extra_data()
	{
		//TODO Retornar os dados adicionais da conta.
	}

	public function send_activation_email()
	{
		//TODO Criar o método que envia a mensagem de ativação por email.
	}

	public function accounts_empty()
	{
		return $this->model->accounts_empty();
	}

//----------------------------------------------------------------
//	Métodos privados
//----------------------------------------------------------------

	private function _create_account($email, $password, $role, $extra_data = array())
	{

		if($this->model->email_exists($email))
			throw new Exception("Email already exists.");

		$data = array(
			'email' => $email,
			'password' => $this->_hash_password($password),
			'role' => $role,
			'extra_data' => json_encode($extra_data, JSON_PRETTY_PRINT),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'created' => date('Y-m-d H:i:s'),
			'updated' => date('Y-m-d H:i:s'),
			'status' => 0
		);

		//TODO Adicionar configuração se envia ou não ativação por email.

		$new_user = $this->model->insert_account($data);

		if(!$new_user > 0)
			throw new Exception('Error creating new account.');

		return $new_user;

	}

	private function _login_account($email, $password, $remember = FALSE, $backlink = NULL)
	{
		$data = array(
			'email' => $email,
			'password' => $this->_hash_password($password)
		);
		$login = $this->model->login_account($data);
		if($login == FALSE)
			return FALSE;
		else {
			$this->_set_session($login);
			return TRUE;
		}
	}

	private function _logout_account()
	{
		return $this->session->sess_destroy();
	}

	private function _send_activation_email()
	{
		//TODO Criar o envio do email com a chave de ativação.
	}

	private function _set_session($user)
	{
		//TODO Buscar as informações de permissão e incluir na sessão.
		if(!$user->id)
			return FALSE;

		$session_data = array(
			'id' => $user->id,
			'email' => $user->email,
			'role' => $user->role,
			'extra_data' => $user->extra_data,
			'logged_in' => TRUE
		);
		$this->session->set_userdata($session_data);
	}

	// Método de criptografia separado para facilitar a mudança do hash.
	private function _hash_password($password, $salt = '')
	{
		//TODO Colocar o salt na configuração da biblioteca.
		//TODO Dar a opção de escolher o hash nas configurações (md5, sha256 etc)
		return md5($password . $salt);
	}


}