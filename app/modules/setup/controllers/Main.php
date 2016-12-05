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
 * This class creates a new admin user if the account table accounts was empty. Usually this occurs in the
 * first run of Wpanel CMS.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.2.2
 */
class Main extends MX_Controller
{

	var $layout_vars = array();
	var $content_vars = array();

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Check if accounts is empty.
		if ($this->auth->accounts_empty() == FALSE)
			redirect('admin/login');

		$this->form_validation->set_rules('password', wpn_lang('input_password', 'Password'), 'required');
		$this->form_validation->set_rules('name', wpn_lang('input_fullname', 'Full name'), 'required');
		$this->form_validation->set_rules('email', wpn_lang('input_validemail', 'Valid email'), 'required|valid_email');
		$this->form_validation->set_rules('agree', wpn_lang('input_agree', 'Terms of use'), 'required');

		if ($this->form_validation->run() == FALSE)
			$this->load->view('setup/index', $this->layout_vars);
		else {
			$newuser = $this->auth->create_account(
				$this->input->post('email', TRUE),
				$this->input->post('password', TRUE),
				'ROOT',
				array(
					'name' => $this->input->post('name'),
					'skin' => 'blue',
					'avatar' => ''
				)
			);
			if($newuser > 0)
			{

				// Activate the first user account.
				$this->auth->activate_account($newuser);

				$this->session->set_flashdata('msg_sistema', wpn_lang('first_account_success', 'Account succefull created'));
				redirect('admin/login');
			} else {
				$this->session->set_flashdata('msg_sistema', wpn_lang('first_account_error', 'Can´t create this account'));
				redirect('setup');
			}
		}
	}
}
