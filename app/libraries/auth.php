<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Eliel de Paula Auth class
 *
 * Provides a basic wai to autenticate users with a 'admin/user' role.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Eliel de Paula <elieldepaula@gmail.com>
 * @link		http://elieldepaula.com.br
 */
class Auth {

	private $CI;

	var $auth_table_name = 'users';
	var $auth_table_key = 'id';
	var $auth_username_field = 'username';
	var $auth_password_field = 'password';
	var $auth_status_field = 'status';
	var $auth_role_field = 'role';
	var $auth_login_redirect = '';
	var $auth_logout_redirect = '';
	var $auth_msg_erro_login = 'You need login to access.';
	var $auth_msg_erro_fail = 'Login failed, try again.';
	var $auth_msg_erro_role = 'You need the right permission to access this area.';

	public function __construct($config = array()) {
		if (count($config) > 0) {
			$this->initialize($config);
		}
		log_message('debug', "Auth Class Initialized");
	}

	public function __get($var) {
		return get_instance()->$var;
	}

	/**
	 * Initialize the library loading the configuration files or
	 * an array() passed on load of the class.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @param $config array()
	 * @return void
	 */
	public function initialize($config = array()) {
		foreach ($config as $key => $val) {
			if (isset($this->$key)) {
				$method = 'set_' . $key;

				if (method_exists($this, $method)) {
					$this->$method($val);
				} else {
					$this->$key = $val;
				}
			}
		}
		return $this;
	}

	/**
	 * Process the login.
	 *
	 * Example of use:
	 * ---------------
	 *
	 * $this->load->library('auth');
	 *
	 * $config = array(
	 *	'user_field' => $_POST['email'],
	 *	'pass_field' => $_POST['password']
	 * );
	 *
	 * $this->auth->login($config);
	 *
	 * Or use $this->auth->login(); - just remember that the fields
	 * of the login form must be the same name in the table.
	 *
	 * ---------------
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @param $options array()
	 * @return mixed
	 */
	public function login($options = array()) {
		if (count($options)<=0) {
			$user = $this->input->post($this->auth_username_field);
			$pass = $this->input->post($this->auth_password_field);
		} else {
			$user = strip_tags($options['user_field']);
			$pass = strip_tags($options['pass_field']);
		}
		if (!$user && !$pass) {
			$this->session->set_flashdata('msg_auth', $this->auth_msg_erro_fail);
			return redirect($this->auth_logout_redirect);
		} else {
			$this->db->where($this->auth_username_field, $user);
			$this->db->where($this->auth_password_field, md5($pass));
			$user_data = $this->db->get($this->auth_table_name)->row();
			if ($user_data->{$this->auth_table_key}) {
				$session_data = array(
					$this->auth_table_key => $user_data->{$this->auth_table_key},
					$this->auth_username_field => $user_data->{$this->auth_username_field},
					$this->auth_role_field => $user_data->{$this->auth_role_field},
					'logged_in' => TRUE
				);
				$this->session->set_userdata($session_data);
				return redirect($this->auth_login_redirect);
			} else {
				$this->session->set_flashdata('msg_auth', $this->auth_msg_erro_fail);
				return redirect($this->auth_logout_redirect);
			}
		}
	}

	/**
	 * Execute an logout from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return mixed
	 */
	public function logout() {
		$session_data = array(
			$this->auth_table_key => null,
			$this->auth_username_field => null,
			$this->auth_role_field => null,
			'logged_in' => TRUE
		);
		$this->session->unset_userdata($session_data);
		return redirect($this->auth_logout_redirect);
	}

	/**
	 * Protect some area checking the login and the role of the user
	 * in the CodeIgnitter Session.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @param $role String
	 * @return mixed
	 */
	public function protect($role = 'user') {
		if ($this->session->userdata('logged_in')) {
			if ($this->session->userdata($this->auth_role_field) != $role) {
				$this->session->set_flashdata('msg_auth', $this->auth_msg_erro_role);
				return redirect($this->auth_logout_redirect);
			}
		} else {
			$this->session->set_flashdata('msg_auth', $this->auth_msg_erro_login);
			return redirect($this->auth_logout_redirect);
		}
	}

	/**
	 * Return the userid from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return String
	 */
	public function get_userid() {
		return $this->session->userdata($this->auth_table_key);
	}

	/**
	 * Return the username from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return String
	 */
	public function get_username() {
		return $this->session->userdata($this->auth_username_field);
	}

	/**
	 * Return the role from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return String
	 */
	public function get_role() {
		return $this->session->userdata($this->auth_role_field);
	}
}