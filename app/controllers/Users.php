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

class Users extends MY_Controller
{

	/**
     * Class constructor.
     *
     * @return void
     */
    function __construct() 
    {
        
        /**
         * Here are some options provided by the MY_Controller class, you
         * can adjust as you need to your project.
         */
        
        /**
         * Enable the CodeIgniter Profile.
         */
        // $this->wpn_profiler = TRUE;
        
        /**
         * Chose the template folder.
         */

        // $this->wpn_template = 'default';
        
        /**
         * Set the 'col' number of the mosaic views.
         */
        // $this->wpn_cols_mosaic = 3;
        
        /**
         * Set the default post view: list (default) or mosaic.
         */
        // $this->wpn_posts_view = 'mosaic';
        
        parent::__construct();
        $this->wpanel->check_setup();
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
    }

    public function index()
    {
        // Check the login.
        if(!is_logged())
            redirect('users/login');
        $this->wpanel->set_meta_title('Área de usuários');
    	$this->render('users_index');
    }

    public function register()
    {
        $this->form_validation->set_rules('name', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Senha', 'required');
        $this->form_validation->set_rules('confpass', 'Confirmação de senha', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->wpanel->set_meta_title('Cadastro de usuários');
            $this->render('users_register');
        } else {
            $extra_data = array(
                'name' => $this->input->post('name'),
                'avatar' => '',
                'skin' => ''
            );
            if($this->auth->create_account($this->input->post('email'), $this->input->post('password'), 'user', $extra_data))
                redirect('users/registerok');
            else {
                $this->session->set_flashdata('msg_contato', 'Sua conta não pode ser criada. Verifique seus dados e tente novamente.');
                redirect('users/register');
            }
        }
    }

    public function registerok()
    {
        $this->wpanel->set_meta_title('Cadastro de usuários');
        $this->render('users_registerok');
    }

    public function profile()
    {
        // Check the login
        if(!is_logged())
            redirect('users/login');
        $query = $this->auth->get_account_by_id();
        $this->data_content['row'] = $query;
        $this->wpanel->set_meta_title('Área de usuários');
    	$this->render('users_profile');
    }

    public function login()
    {
        $this->form_validation->set_rules('email', wpn_lang('input_email', 'Email'), 'required|valid_email');
        $this->form_validation->set_rules('password', wpn_lang('input_password', 'Password'), 'required');
        if ($this->form_validation->run() == FALSE){
            $this->wpanel->set_meta_title('Login de usuários');
            $this->render('users_login');
        }
        else {
            if($this->auth->login($this->input->post('email'), $this->input->post('password')))
                return redirect('users');
            else {
                $this->session->set_flashdata('msg_sistema', 'Seu login falhou, tente novamente.');
                return redirect('users/login');
            }
        }
    }

    public function logout()
    {
    	$this->auth->logout();
        redirect();
    }
}