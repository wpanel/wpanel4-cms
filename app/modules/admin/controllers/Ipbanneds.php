<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
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
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Esta é a classe do módulo de administração Ipbanneds, ela foi
 * gerada automaticamente pela ferramenta Wpanel-GEN para a criação
 * de códigos padrão para o Wpanel CMS.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @version		0.0.1
 */
class Ipbanneds extends MX_Controller
{

    /**
     * Método construtor.
     */
    function __construct()
    {
        $this->auth->check_permission();
        $this->load->model('ipban');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
    }

    /**
     * Mostra a lista de registros.
     * 
     * @return mixed
     */
    public function index()
    {
        $this->load->library('table');
        $layout_vars = array();
        $content_vars = array();
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('#', 'Endereço IP', 'Data', 'Ações');
        $query = $this->ipban->get_list()->result();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->ip_address, date('d/m/Y H:i:s', strtotime($row->created)),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/ipbanneds/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $content_vars['listagem'] = $this->table->generate();
        $this->wpanel->load_view('ipbanneds/index', $content_vars);
    }

    /**
     * Mostra o formulário e cadastra um novo registro.
     * 
     * @return mixed
     */
    public function add()
    {
        $layout_vars = array();
        $content_vars = array();
        $this->form_validation->set_rules('ip_address', 'Endereço IP', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->wpanel->load_view('ipbanneds/add', $content_vars);
        } else
        {
            $data = array();
            $data['ip_address'] = $this->input->post('ip_address');
            $data['created'] = date('Y-m-d H:i:s');

            if ($this->ipban->save($data))
            {
                $this->session->set_flashdata('msg_sistema', 'Registro salvo com sucesso.');
                redirect('admin/ipbanneds');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o registro.');
                redirect('admin/ipbanneds');
            }
        }
    }

    /**
     * Exclui um registro.
     * 
     * @param $id int Id do registro a ser excluído.
     * @return mixed
     */
    public function delete($id = null)
    {
        if ($id == null)
        {
            $this->session->set_flashdata('msg_sistema', 'Registro inexistente.');
            redirect('admin/ipbanneds');
        }
        if ($this->ipban->delete($id))
        {
            $this->session->set_flashdata('msg_sistema', 'Registro excluído com sucesso.');
            redirect('admin/ipbanneds');
        } else
        {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o registro.');
            redirect('admin/ipbanneds');
        }
    }

}

// End of file modules/admin/controllers/Ipbanneds.php