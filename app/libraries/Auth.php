<?php 
/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Eliel de Paula Auth class
 *
 * Provides a basic way to autenticate users with a 'admin/user' role.
 *
 * @package		Auth
 * @category	Libraries
 * @author		Eliel de Paula <dev@elieldepaula.com.br>
 * @link		http://elieldepaula.com.br
 */
class Auth 
{
	
	var $auth_table_name 		= 'users';
	var $auth_table_key 		= 'id';
	var $auth_name_field 		= 'name';
	var $auth_username_field 	= 'username';
	var $auth_password_field 	= 'password';
	var $auth_status_field 		= 'status';
	var $auth_role_field 		= 'role';
	var $auth_permissions_field	= 'permissions';
	var $auth_login_redirect 	= '';
	var $auth_logout_redirect	= '';
	var $auth_msg_erro_login 	= 'You need login to access.';
	var $auth_msg_erro_fail 	= 'Login failed, try again.';
	var $auth_msg_erro_role 	= 'You need the right permission to access this area.';

	public function __construct($config = array()) 
	{
		if (count($config) > 0) 
		{
			$this->initialize($config);
		}
		log_message('debug', "Auth Class Initialized");
	}

	public function __get($var) 
	{
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
	public function initialize($config = array()) 
	{
		foreach ($config as $key => $val) 
		{
			if (isset($this->$key)) 
			{
				$method = 'set_' . $key;

				if (method_exists($this, $method)) 
				{
					$this->$method($val);
				}
				else
				{
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
	public function login($options = array()) 
	{
		if (count($options)<=0) 
		{
			$user = $this->input->post($this->auth_username_field);
			$pass = $this->input->post($this->auth_password_field);
		}
		else
		{
			$user = strip_tags($options['user_field']);
			$pass = strip_tags($options['pass_field']);
		}
		if (!$user && !$pass)
		{
			$this->session->set_flashdata('msg_auth', $this->auth_msg_erro_fail);
			return redirect($this->auth_logout_redirect);
		}
		else
		{
			$this->db->where($this->auth_username_field, $user);
			$this->db->or_where('username', $user); // Modificação para o wpanel.
			$this->db->where($this->auth_password_field, md5($pass));
			$this->db->where($this->auth_status_field, 1);
			$user_data = $this->db->get($this->auth_table_name)->row();
			if ($user_data->{$this->auth_table_key})
			{
				$session_data = array(
					$this->auth_table_key => $user_data->{$this->auth_table_key},
					$this->auth_username_field => $user_data->{$this->auth_username_field},
					$this->auth_role_field => $user_data->{$this->auth_role_field},
					$this->auth_permissions_field => $user_data->{$this->auth_permissions_field},
					$this->auth_name_field => $user_data->{$this->auth_name_field},
					'logged_in' => TRUE
				);
				$this->session->set_userdata($session_data);
				return redirect($this->auth_login_redirect);
			}
			else
			{
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
	public function logout()
	{
		$session_data = array(
			$this->auth_table_key => null,
			$this->auth_username_field => null,
			$this->auth_role_field => null,
			$this->auth_permissions_field => null,
			$this->auth_name_field => null,
			'logged_in' => TRUE
		);
		$this->session->unset_userdata($session_data);
		return redirect($this->auth_logout_redirect);
	}

	/**
	 * Protect some area checking the login and the role permissions of the user
	 * in the CodeIgnitter Session.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @param $modulename String Name of the module in /app/config/modules.php
	 * @return mixed
	 */
	public function protect($modulename = '')
	{
		if ($this->session->userdata('logged_in'))
		{
			if (
				($this->session->userdata($this->auth_role_field) == 'user') and 
				(!in_array($modulename, unserialize($this->session->userdata($this->auth_permissions_field))))
				)
			{
				$this->session->set_flashdata('msg_auth', $this->auth_msg_erro_role);
				return redirect($this->auth_logout_redirect);
			}
		}
		else
		{
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
	public function get_userid()
	{
		return $this->session->userdata($this->auth_table_key);
	}

	/**
	 * Return the username from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return String
	 */
	public function get_username()
	{
		return $this->session->userdata($this->auth_username_field);
	}

	public function get_name()
	{
		return $this->session->userdata($this->auth_name_field);
	}

	/**
	 * Return the role from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return String
	 */
	public function get_role()
	{
		return $this->session->userdata($this->auth_role_field);
	}
}