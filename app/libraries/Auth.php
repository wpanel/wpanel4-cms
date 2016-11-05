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
			$user = $this->input->post('email', true);
			$pass = $this->input->post('password', true);
		}
		else
		{
			$user = strip_tags($options['user_field']);
			$pass = strip_tags($options['pass_field']);
		}
		if (!$user && !$pass)
		{
			$this->session->set_flashdata('msg_auth', 'Seu login falhou, tente novamente.');
			return redirect('/admin/login');
		}
		else
		{
			$this->db->where('email', $user);
			$this->db->or_where('username', $user);
			$this->db->where('password', md5($pass));
			$this->db->where('status', 1);
			$user_data = $this->db->get('users')->row();
			if ($user_data->id)
			{
				$session_data = array(
					'id' => $user_data->id,
					'email' => $user_data->email,
					'role' => $user_data->role,
					'permissions' => $user_data->permissions,
					'name' => $user_data->name,
                    'user_object' => $user_data,
					'logged_in' => TRUE
				);
				$this->session->set_userdata($session_data);
				return redirect('/admin');
			}
			else
			{
				$this->session->set_flashdata('msg_auth', 'Seu login falhou, tente novamente.');
				return redirect('/admin/login');
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
			'id' => null,
			'email' => null,
			'role' => null,
			'permissions' => null,
			'name' => null,
            'user_object' => null,
			'logged_in' => TRUE
		);
		$this->session->unset_userdata($session_data);
		return redirect('/admin/login');
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
				($this->session->userdata('role') == 'user') and 
				(!in_array($modulename, unserialize($this->session->userdata('permissions'))))
				)
			{
				$this->session->set_flashdata('msg_auth', 'Você não tem permissão para acessar esta área.');
				return $this->logout();
			}
		}
		else
		{
			$this->session->set_flashdata('msg_auth', 'Você precisa logar para acessar.');
			return redirect('/admin/login');
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
		return $this->session->userdata('id');
	}

	/**
	 * Return the username from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return String
	 */
	public function get_username()
	{
		return $this->session->userdata('name');
	}

	/**
	 * Return the role from an logged user.
	 *
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @return String
	 */
	public function get_role()
	{
		return $this->session->userdata('role');
	}
}