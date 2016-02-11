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
 * Esta classe forma o conjunto de funcionalidades do Logon do Wpanel
 *
 * @package Wpanel
 * @author Eliel de Paula <dev@gelieldepaula.com.br>
 * @since v1.2.2 12/09/2015
 **/
class Logon extends MX_Controller {

	function __construct()
	{
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	/**
	 * Este método faz o login do usuário no wpanel.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function index()
	{
		$this->load->model('user');
		
		if ($this->user->inicial_user() == false) redirect('admin/dashboard/firstadmin');

		$this->form_validation->set_rules('email', 'Nome de usuário ou email', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required');
		
		if ($this->form_validation->run() == FALSE)
			$this->load->load->view('logon/index');
		else {
			$conf_login = array('user_field' => $this->input->post('email'),'pass_field' => $this->input->post('password'));
			$this->auth->login($conf_login);
		}
	}

	/**
	 * Este método faz o logout do usuário.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function out()
	{
		$this->auth->logout();
	}
	
	/**
	 * Este método faz o procedimento de recuperação de senhas de usuários do wpanel.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function recovery($recovery_key = null)
	{

		$this->load->library('email');

		if ($this->wpanel->get_config('usa_smtp') == 1) 
		{
			$conf_email = array();
			$conf_email['protocol'] = 'smtp';
			$conf_email['smtp_host'] = $this->wpanel->get_config('smtp_servidor');
			$conf_email['smtp_port'] = $this->wpanel->get_config('smtp_porta');
			$conf_email['smtp_user'] = $this->wpanel->get_config('smtp_usuario');
			$conf_email['smtp_pass'] = $this->wpanel->get_config('smtp_senha');
			$this->email->initialize($conf_email);
		}

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			if($recovery_key == null)
				$this->load->view('logon/recovery');
			else {

				$this->load->model('user');
				$chave	= explode(',', base64_decode(strrev($recovery_key)));
				$id		= $chave[0];
				$nome	= $chave[1];
				$email	= $chave[2];
				$senha  = md5('123mudar');

				$dados_save = array();
				$dados_save['password'] = $senha;

				if($this->user->update($id, $dados_save))
				{

					$mensagem = "";
					$mensagem .= "Olá ".$nome.", esta é uma mensagem automática, não responda este email. \n\n";
					$mensagem .= "Sua senha de acesso ao painel de controle foi redefinida com sucesso! ";
					$mensagem .= "Anote os seus novos dados: \n\n";
					$mensagem .= "Email: ".$email." \n";
					$mensagem .= "Senha: 123mudar \n\n";
					$mensagem .= "ATENÇÃO!!!\n\nMude a senha imediatamente após o login, esta é uma senha ";
					$mensagem .= "temporária e caso não seja alterada seu acesso será revogado. \n\n";

					$this->email->to($email);
					$this->email->from($this->wpanel->get_config('site_contato'), $this->wpanel->get_config('site_titulo'));
					$this->email->subject('Senha redefinida');
					$this->email->message($mensagem);
					$this->email->send();

					$this->session->set_flashdata('msg_auth', 'Sua senha foi redefinida e enviamos seus novos dados de acesso para seu email, caso não receba verifique sua caixa de SPAM.');
					redirect('admin/login');
				} else {
					$this->session->set_flashdata('msg_recover', 'Houve um problema e sua senha não pode ser redefinida, entre em contato conosco pelo email <b>'.$this->wpanel->get_config('site_contato').'</b>.');
					redirect('admin/recovery');
				}
			}
		} else {

			$this->load->model('user');

			$query = $this->user->get_by_field('email', $this->input->post('email'))->row();

			if(count($query) >= 1)
			{

				$recovery_key	= strrev(base64_encode($query->id.','.$query->name.','.$query->email));
				$recovery_link	= base_url('admin/recovery').'/'.$recovery_key;

				$mensagem = "";
				$mensagem .= "Olá ".$query->name.", esta é uma mensagem automática, não responda este email. \n\n";
				$mensagem .= "Recebemos uma solicitação de redefinição de senha de acesso ao seu painel de controle ";
				$mensagem .= "em nosso site. Para concluir a redefinição clique no link abaixo: \n\n";
				$mensagem .= "Link: ".$recovery_link." \n\n";
				$mensagem .= "Caso vocẽ não tenha solicitado a redefinição de sua senha por favor ignore esta mensagem. \n\n";
				$mensagem .= "Data/Hora da solicitação: ".date('d/m/Y H:i')."\n";
				$mensagem .= "IP da conexão: ".$_SERVER['REMOTE_ADDR']." \n\n";

				$this->email->to($query->email);
				$this->email->from($this->wpanel->get_config('site_contato'), $this->wpanel->get_config('site_titulo'));
				$this->email->subject('Redefinição de senha');
				$this->email->message($mensagem);
				$this->email->send();

				$this->session->set_flashdata('msg_auth', 'Enviamos as instruções para redefinição de sua senha no seu email informado no cadastro.');
				redirect('admin/login');
			} else {
				$this->session->set_flashdata('msg_recover', 'Usuário inexistente.');
				redirect('admin/recovery');
			}
		}
	}
}