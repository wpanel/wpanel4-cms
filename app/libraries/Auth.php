<?php 

/**
* Nova biblioteca de autenticação com ACL.
*
* Esta versão tem como objetivo:
* - gerenciar os usua´rios (crud)
* - gerenciar a ativação/desativação
* - gerenciar os IP´s banidos
* - Gerenciar módulos e actions
* - fazer o login e logout do usuário
* - registrar os logins realizados
* - limitar o acesso por excesso de tentativas
* - lembrar login (remember me) com cookies
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

	protected $auth_white_list = array();

	// Construtor
	public function __construct($config = array()) 
	{
		if (count($config) > 0)
			$this->initialize($config);
		$this->load->model('auth_model', 'model');
		log_message('debug', "Auth Class Initialized");
	}

	// Permite que use a instância do CI
	public function __get($var) 
	{
		return get_instance()->$var;
	}

	/**
	 * Initialize the library loading the configuration files or
	 * an array() passed on load of the class.
	 *
	 * @param $config array()
	 * @return void
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val) {
			if (isset($this->$key)) {
				$method = 'set_' . $key;
				if (method_exists($this, $method))
					$this->$method($val);
				else
					$this->$key = $val;

			}
		}
		return $this;
	}

//----------------------------------------------------------------
//	Métodos da API pública
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

	public function get_account_by_id($id = NULL)
	{
		return $this->_get_account_by_id($id);
	}

	public function get_account_list()
	{
		//TODO Listar as contas.
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
		return $this->_get_login_data('id');
	}

	public function get_login_data($item = NULL)
	{
		return $this->_get_login_data($item);
	}

	public function get_extra_data($item = NULL, $json = NULL)
	{
		return $this->_get_extra_data($item, $json);
	}

	public function send_activation_email()
	{
		//TODO Criar o método que envia a mensagem de ativação por email.
	}

	public function accounts_empty()
	{
		//TODO Verificar se convém deixar a chamada ao model diretamente no método público.
		return $this->model->accounts_empty();
	}

	public function check_permission_by_hook()
	{
		if($this->config->item('auth_check_permyssion_by_hook') == TRUE)
			return $this->check_permission();
	}

	// Exemplo retirado do projeto ACL no Github.
	public function check_permission()
	{
		echo $this->config->item('auth_white_list');
		return $this->_check_permission();
	}

//----------------------------------------------------------------
//	Métodos privados
//----------------------------------------------------------------

	/**
	 * Create a new account.
	 *
	 * @param $email
	 * @param $password
	 * @param $role
	 * @param array $extra_data
	 * @return mixed
	 * @throws Exception
	 */
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

	/**
	 * Login into an account.
	 *
	 * @param $email
	 * @param $password
	 * @param bool|FALSE $remember
	 * @param null $backlink
	 * @return bool
	 */
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

	/**
	 * Logout from an login session.
	 *
	 * @return mixed
	 */
	private function _logout_account()
	{
		return $this->session->sess_destroy();
	}

	private function _send_activation_email()
	{
		//TODO Criar o envio do email com a chave de ativação.
	}

	/**
	 * Setup a login session.
	 *
	 * @param $account
	 * @return bool
	 */
	private function _set_session($account)
	{
		//TODO Buscar as informações de permissão e incluir na sessão.
		if(!$account->id)
			return FALSE;

		$session_data = array(
			'id' => $account->id,
			'email' => $account->email,
			'role' => $account->role,
			'extra_data' => $account->extra_data,
			'created' => $account->created,
			'logged_in' => TRUE
		);
		$this->session->set_userdata($session_data);
	}

	/**
	 * Return an extra-data item from an login or all the object.
	 *
	 * @param null $item
	 * @return object
	 */
	private function _get_extra_data($item = NULL, $json = nULL)
	{
		if($json == NULL)
			$json = $this->_get_login_data('extra_data');
		$cobj = (object) json_decode($json);
		if($item == NULL)
			return $cobj;
		else
			return $cobj->$item;
	}

	/**
	 * Return an item from the login session.
	 *
	 * @param null $item
	 * @return bool
	 */
	private function _get_login_data($item = NULL)
	{
		if($item == NULL)
			return FALSE;
		else
			return $this->session->userdata($item);
	}

	private function _get_account_by_id($id = NULL)
	{
		if($id == NULL)
			$id = $this->_get_login_data('id');
		return $this->model->account_by_id($id);
	}

	private function _check_permission()
	{
		$account_id = $this->get_account_id();
		$account_role = $this->_get_login_data('role');
		if ($account_id == '') {
			$this->session->flashdata('msg_auth', 'User is not logged.');
			redirect('admin/logout');
			exit;
		} else {

			$url = $this->uri->uri_string();
			($this->uri->total_segments() == 3)? $url.'/' : $url;

			if($account_role == 'ROOT')
				return TRUE;
			if($url == '')
				return TRUE;
			if(in_array($this->_prepare_url($url), $this->auth_white_list))
				return TRUE;
			if ($this->model->validate_white_list($url))
				return TRUE;
			if ($this->model->validate_permission($account_id, $url) === false){
				$this->session->flashdata('msg_sistema', 'User don\'t has permission.');
				redirect('admin/dashboard');
				exit;
			}
			return TRUE;
		}
	}
	/**
	 * Return a hashed password.
	 *
	 * @param $password
	 * @param string $salt
	 * @return string
	 */
	private function _hash_password($password)
	{
		switch ($this->auth_password_hash_type) {
			case 'md5':
				return md5($password . $this->auth_password_hash_salt);
				break;
			
			case 'something':
				//TODO Codificar outras opções de criptografia aqui.
				break;
		}
	}

	private function _prepare_url($url)
	{
		//TODO Aprender uma forma mais elegante de fazer isso. :)
		$x = explode('/', $url);
		$out = '';
		$bar = '/';
		foreach ($x as $key => $value) {
			if($key > 2)
				$value = '*';
			if($key == 0)
				$out .= $value;
			else
				$out .= $bar . $value;
		}
		return $out;
	}

}