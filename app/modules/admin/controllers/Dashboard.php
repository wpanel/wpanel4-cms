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
 * Esta classe forma o conjunto de funcionalidades do Dashboard do Wpanel
 *
 * @package Wpanel
 * @author Eliel de Paula <dev@gelieldepaula.com.br>
 **/
class Dashboard extends MX_Controller {

	function __construct()
	{

		// Protege o acesso do dashboard independente de permissão.
		//if(!$this->session->userdata('logged_in'))
		//	redirect('admin/logout');
		$this->auth->check_permission();
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
		$this->load->model('dash');
	}

	public function index()
	{

		$layout_vars = array();
		$content_vars = array();

		$content_vars['total_posts'] 	= $this->dash->calcula_totais('posts', '0');
		$content_vars['total_paginas'] 	= $this->dash->calcula_totais('posts', '1');
		$content_vars['total_agendas'] 	= $this->dash->calcula_totais('posts', '2');
		$content_vars['total_banners'] 	= $this->dash->calcula_totais('banners');
		$content_vars['total_albuns'] 	= $this->dash->calcula_totais('albuns');
		$content_vars['total_videos'] 	= $this->dash->calcula_totais('videos');
		//----------------------------------------------------------------------------------------------------

		$this->wpanel->load_view('dashboard/index', $content_vars);

	}
}