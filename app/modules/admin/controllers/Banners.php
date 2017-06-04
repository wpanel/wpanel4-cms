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

class Banners extends MX_Controller
{

    function __construct()
    {
        $this->auth->check_permission();
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        $this->load->model('banner');
    }

    public function index()
    {
        $this->load->library('table');

        $layout_vars = array();
        $content_vars = array();
        $options = config_item('banner_positions');

        $query = $this->banner->get_list(array('field' => 'sequence', 'order' => 'asc'))->result(); // ordenar pela sequencia dos banners. 

        $content_vars['query'] = $query;
        $content_vars['options'] = $options;

        $this->wpanel->load_view('banners/index', $content_vars);
    }

    public function update_sequence()
    {
        $i = 0;
        $itens = $_POST['item']; //$this->input->post('item');
        foreach ($itens as $value)
        {
            // Execute statement:
            $this->banner->update($value, array('sequence' => $i));
            $i++;
        }
    }

    public function add()
    {
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('sequence', 'Ordem', 'required');
        $this->form_validation->set_rules('position', 'Posição', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->wpanel->load_view('banners/add', $content_vars);
        } else
        {

            $dados_save = array();
            $dados_save['user_id'] = $this->auth->get_userid();
            $dados_save['title'] = $this->input->post('title');
            $dados_save['sequence'] = $this->input->post('sequence');
            $dados_save['position'] = $this->input->post('position');
            $dados_save['status'] = $this->input->post('status');
            $dados_save['created'] = date('Y-m-d H:i:s');
            $dados_save['updated'] = date('Y-m-d H:i:s');
            $dados_save['content'] = $this->banner->upload_media('banners');

            $new_post = $this->banner->save($dados_save);

            if ($new_post)
            {
                $this->session->set_flashdata('msg_sistema', 'Banner salvo com sucesso.');
                redirect('admin/banners');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o banner.');
                redirect('admin/banners');
            }
        }
    }

    public function edit($id = null)
    {
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('sequence', 'Ordem', 'required');
        $this->form_validation->set_rules('position', 'Posição', 'required');

        if ($this->form_validation->run() == FALSE)
        {

            if ($id == null)
            {
                $this->session->set_flashdata('msg_sistema', 'Banner inexistente.');
                redirect('admin/banners');
            }

            $content_vars['id'] = $id;
            $content_vars['row'] = $this->banner->get_by_id($id)->row();
            $this->wpanel->load_view('banners/edit', $content_vars);
        } else
        {

            $dados_save = array();
            $dados_save['title'] = $this->input->post('title');
            $dados_save['sequence'] = $this->input->post('sequence');
            $dados_save['position'] = $this->input->post('position');
            $dados_save['status'] = $this->input->post('status');
            $dados_save['updated'] = date('Y-m-d H:i:s');

            if ($this->input->post('alterar_imagem') == '1')
            {
                $banner = $this->banner->get_by_id($id)->row();
                $this->banner->remove_media('banners/' . $banner->content);

                $dados_save['content'] = $this->banner->upload_media('banners');
            }

            $new_post = $this->banner->update($id, $dados_save);

            if ($new_post)
            {
                $this->session->set_flashdata('msg_sistema', 'Banner salvo com sucesso.');
                redirect('admin/banners');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o banner.');
                redirect('admin/banners');
            }
        }
    }

    public function delete($id = null)
    {

        if ($id == null)
        {
            $this->session->set_flashdata('msg_sistema', 'Banner inexistente.');
            redirect('admin/banners');
        }

        // Remove o arquivo do banner.
        $banner = $this->banner->get_by_id($id)->row();
        $this->banner->remove_media('banners/' . $banner->content);

        if ($this->banner->delete($id))
        {
            $this->session->set_flashdata('msg_sistema', 'Banner excluído com sucesso.');
            redirect('admin/banners');
        } else
        {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o banner.');
            redirect('admin/banners');
        }
    }

}
