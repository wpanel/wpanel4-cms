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
 * Esta é a classe do módulo de administração Moduloitens, ela foi
 * gerada automaticamente pela ferramenta Wpanel-GEN para a criação
 * de códigos padrão para o Wpanel CMS.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @version		0.0.1
 */
class Moduloitens extends MX_Controller {
	
	/**
	* Método construtor.
	*/
	function __construct()
	{
//		$this->auth->protect('moduloitens');
		$this->load->model('module_action');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}
	
	/**
	* Mostra a lista de registros.
	* 
	* @return mixed
	*/
	public function index()
	{
		redirect('admin/modulos');
	}
	
	/**
	* Mostra o formulário e cadastra um novo registro.
	* 
	* @return mixed
	*/
	public function add($module_id = NULL)
	{
		$layout_vars = array();
		$content_vars = array();
		$this->form_validation->set_rules('description', 'Descrição', 'required');
		$this->form_validation->set_rules('link', 'Link', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$content_vars['module_id'] = $module_id;
			$this->wpanel->load_view('moduloitens/add', $content_vars);
		} else {
			$data = array();
			$data['module_id'] = $module_id;
			$data['description'] = $this->input->post('description');
			$data['link'] = $this->input->post('link');
			if($this->input->post('whitelist') == '1')
				$data['whitelist'] = '1';
			else
				$data['whitelist'] = '0';
			$data['created'] = date('Y-m_d H:i:s');
			$data['updated'] = date('Y-m_d H:i:s');
			
			if($this->module_action->save($data))
			{
				$this->session->set_flashdata('msg_sistema', 'Registro salvo com sucesso.');
				redirect('admin/modulos/edit/'.$module_id);
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o registro.');
				redirect('admin/modulos/edit/'.$module_id);
			}
		}
	}
	
	/**
	* Mostra o formulário e altera um registro.
	* 
	* @param $id int Id do registro a ser editado.
	* @return mixed
	*/
	public function edit($id = NULL, $module_id = NULL)
	{
		$layout_vars = array();
		$content_vars = array();
		$this->form_validation->set_rules('description', 'Descrição', 'required');
		$this->form_validation->set_rules('link', 'Link', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			if($id == NULL){
				$this->session->set_flashdata('msg_sistema', 'Registro inexistente.');
				redirect('admin/moduloitens');
			}
			$content_vars['module_id'] = $module_id;
			$content_vars['row'] = $this->module_action->get_by_id($id)->row();
			$this->wpanel->load_view('moduloitens/edit', $content_vars);
		} else {
			$data = array();
			$data['module_id'] = $module_id;
			$data['description'] = $this->input->post('description');
			$data['link'] = $this->input->post('link');
			if($this->input->post('whitelist') == '1')
				$data['whitelist'] = '1';
			else
				$data['whitelist'] = '0';
			$data['updated'] = date('Y-m_d H:i:s');
			
			if($this->module_action->update($id, $data))
			{
				$this->session->set_flashdata('msg_sistema', 'Registro salvo com sucesso.');
				redirect('admin/modulos/edit/'.$module_id);
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o registro.');
				redirect('admin/modulos/edit/'.$module_id);
			}
		}
	}
	
	/**
	* Exclui um registro.
	* 
	* @param $id int Id do registro a ser excluído.
	* @return mixed
	*/
	public function delete($id = NULL, $module_id = NULL)
	{
		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Registro inexistente.');
			redirect('admin/modulos');
		}
		if($this->module_action->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Registro excluído com sucesso.');
			redirect('admin/modulos/edit/'.$module_id);
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir o registro.');
			redirect('admin/modulos/edit/'.$module_id);
		}
	}
}

// End of file modules/admin/controllers/Moduloitens.php