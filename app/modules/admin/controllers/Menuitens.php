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

class Menuitens extends MX_Controller
{

    function __construct()
    {
        $this->auth->check_permission();
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        $this->load->model('menu_item');
    }

    public function index()
    {
        redirect('admin/menus');
    }

    public function add($menu_id)
    {

        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('label', 'Label', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->model('post');
            $this->load->model('categoria');
            $this->load->model('menu');
            $content_vars['menu_id'] = $menu_id;
            $content_vars['posts'] = $this->post->get_list()->result();
            $content_vars['categorias'] = $this->categoria->get_list()->result();
            $content_vars['menus'] = $this->menu->get_list()->result();
            $this->wpanel->load_view('menuitens/add', $content_vars);
        } else
        {
            $tipo_link = $this->input->post('tipo');
            $dados_save = array();
            $dados_save['menu_id'] = $menu_id;
            $dados_save['label'] = $this->input->post('label');
            $dados_save['tipo'] = $tipo_link;
            $dados_save['slug'] = '';
            $dados_save['ordem'] = $this->input->post('ordem');
            $dados_save['created'] = date('Y-m-d H:i:s');
            $dados_save['updated'] = date('Y-m-d H:i:s');
            // Verifica de onde vem os dados para o campo 'link'
            switch ($tipo_link)
            {
                case 'link':
                    $dados_save['href'] = $this->input->post('link');
                    break;
                case 'post':
                    $dados_save['href'] = $this->input->post('post_id');
                    break;
                case 'posts':
                    $dados_save['href'] = $this->input->post('categoria_id');
                    break;
                case 'funcional':
                    $dados_save['href'] = $this->input->post('funcional');
                    break;
                case 'submenu':
                    $dados_save['href'] = $this->input->post('submenu');
                    break;
            }

            if ($this->menu_item->save($dados_save))
            {
                $this->session->set_flashdata('msg_sistema', 'Item de menu salvo com sucesso.');
                redirect('admin/menus');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o ítem de menu.');
                redirect('admin/menus');
            }
        }
    }

    public function edit($id = null)
    {
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('label', 'Label', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');

        if ($this->form_validation->run() == FALSE)
        {

            if ($id == null)
            {
                $this->session->set_flashdata('msg_sistema', 'Item de menu inexistente.');
                redirect('admin/menus');
            }

            $this->load->model('post');
            $this->load->model('categoria');
            $this->load->model('menu');

            $content_vars['posts'] = $this->post->get_list()->result();
            $content_vars['categorias'] = $this->categoria->get_list()->result();
            $content_vars['menus'] = $this->menu->get_list()->result();
            $content_vars['id'] = $id;
            $content_vars['row'] = $this->menu_item->get_by_id($id)->row();
            $this->wpanel->load_view('menuitens/edit', $content_vars);
        } else
        {

//            $menu_id = $this->input->post('menu_id');
            $tipo_link = $this->input->post('tipo');
            $dados_save = array();
            $dados_save['label'] = $this->input->post('label');
            $dados_save['tipo'] = $tipo_link;
            $dados_save['slug'] = '';
            $dados_save['ordem'] = $this->input->post('ordem');
            $dados_save['updated'] = date('Y-m-d H:i:s');

            // Verifica de onde vem os dados para o campo 'link'
            switch ($tipo_link)
            {
                case 'link':
                    $dados_save['href'] = $this->input->post('link');
                    break;
                case 'post':
                    $dados_save['href'] = $this->input->post('post_id');
                    break;
                case 'posts':
                    $dados_save['href'] = $this->input->post('categoria_id');
                    break;
                case 'funcional':
                    $dados_save['href'] = $this->input->post('funcional');
                    break;
                case 'submenu':
                    $dados_save['href'] = $this->input->post('submenu');
                    break;
            }

            if ($this->menu_item->update($id, $dados_save))
            {
                $this->session->set_flashdata('msg_sistema', 'Item de menu salvo com sucesso.');
                redirect('admin/menus');
            } else
            {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o item de menu.');
                redirect('admin/menus');
            }
        }
    }

    public function delete($id = null)
    {

        if ($id == null)
        {
            $this->session->set_flashdata('msg_sistema', 'Item de menu inexistente.');
            redirect('admin/menus');
        }

        if ($this->menu_item->delete($id))
        {
            $this->session->set_flashdata('msg_sistema', 'Item de menu excluído com sucesso.');
            redirect('admin/menus');
        } else
        {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o item de menu.');
            redirect('admin/menus');
        }
    }

}
