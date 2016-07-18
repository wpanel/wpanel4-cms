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

class menus extends MX_Controller
{

    function __construct()
    {
        $this->auth->protect('menus');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        $this->load->model('menu');
    }

    public function index()
    {

        $layout_vars = array();
        $content_vars = array();
        $this->load->model('menu_item');

        $query_menu = $this->menu->get_list();

        $html_menu = "";
        foreach ($query_menu->result() as $row)
        {
            $html_menu .= "<li class=\"list-group-item\"><div class=\"row\">";
            $html_menu .= "<div class=\"col-md-1 col-sm-1\"><b>[" . $row->id . "]</b></div>";
            $html_menu .= "<div class=\"col-md-9 col-sm-9\">" . $row->nome . "</div>";
            $html_menu .= "<div class=\"col-md-2 col-sm-2 btn-group btn-group-xs\">";
            $html_menu .= anchor('admin/menus/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default'));
            $html_menu .= '<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/menus/delete/' . 
                $row->id).'\');">'.glyphicon('trash').'</button>';
            $html_menu .= "</div>";
            $html_menu .= "</div></li>";
            $html_menu .= "<li class=\"list-group-item\">";
            $html_menu .= $this->get_menu_item($row->id);
            $html_menu .= "</li>";
        }

        $content_vars['listagem'] = $html_menu;
        $this->wpanel->load_view('menus/index', $content_vars);
    }

    private function get_menu_item($menu_id)
    {

        $this->load->library('table');
        $this->load->model('menu_item');

        $content_vars = array();

        // Template da tabela
        $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered">'));
        $this->table->set_heading('Label', 'Ordem', 'Tipo', 'Link', 'Ações');
        $query = $this->menu_item->get_by_field('menu_id', $menu_id, array('field' => 'ordem', 'order' => 'asc'));

        foreach ($query->result() as $row)
        {

            switch ($row->tipo)
            {
                case 'post':
                    $link = $this->get_titulo_postagem($row->href);
                    break;
                case 'posts':
                    $link = $this->get_titulo_categoria($row->href);
                    break;
                case 'link':
                    $link = $row->href;
                    break;
                case 'funcional':
                    $link = humanize($row->href);
                    break;
                case 'submenu':
                    $link = $this->get_titulo_menu($row->href);
                    break;
            }

            $this->table->add_row(
                    $row->label, $row->ordem, humanize($row->tipo), $link, div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/menuitens/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/menuitens/delete/' . 
                        $row->id).'\');">'.glyphicon('trash').'</button>' .
                    div(null, true)
            );
        }

        $content_vars['menu_id'] = $menu_id;
        $content_vars['listagem'] = $this->table->generate();
        return $this->load->view('menuitens/index', $content_vars, TRUE);
    }

    private function get_titulo_postagem($post_link)
    {
        $this->load->model('post');
        $query = $this->post->get_by_field('link', $post_link)->row();
        return $query->title;
    }

    private function get_titulo_categoria($categoria_id)
    {
        $this->load->model('categoria');
        $query = $this->categoria->get_by_id($categoria_id)->row();
        return $query->title;
    }
    
    private function get_titulo_menu($menu_id)
    {
        $this->load->model('menu');
        $query = $this->menu->get_by_id($menu_id)->row();
        return $query->nome;
    }

    public function add()
    {

        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('nome', 'Nome', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->wpanel->load_view('menus/add', $content_vars);
        } else {

            $dados_save = array();
            $dados_save['user_id'] = $this->auth->get_userid();
            $dados_save['nome'] = $this->input->post('nome');
            $dados_save['slug'] = strtolower(url_title(convert_accented_characters($this->input->post('nome'))));
            $dados_save['posicao'] = $this->input->post('posicao');
            $dados_save['estilo'] = $this->input->post('estilo');
            $dados_save['created'] = date('Y-m-d H:i:s');
            $dados_save['updated'] = date('Y-m-d H:i:s');

            if ($this->menu->save($dados_save)) {
                $this->session->set_flashdata('msg_sistema', 'Menu salvo com sucesso.');
                redirect('admin/menus');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o menu.');
                redirect('admin/menus');
            }
        }
    }

    public function edit($id = null)
    {

        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('nome', 'Nome', 'required');

        if ($this->form_validation->run() == FALSE) {

            if ($id == null) {
                $this->session->set_flashdata('msg_sistema', 'Menu inexistente.');
                redirect('admin/menus');
            }

            $content_vars['id'] = $id;
            $content_vars['row'] = $this->menu->get_by_id($id)->row();
            $this->wpanel->load_view('menus/edit', $content_vars);
        } else {

            $dados_save = array();
            $dados_save['nome'] = $this->input->post('nome');
            $dados_save['slug'] = strtolower(url_title(convert_accented_characters($this->input->post('nome'))));
            $dados_save['posicao'] = $this->input->post('posicao');
            $dados_save['estilo'] = $this->input->post('estilo');
            $dados_save['updated'] = date('Y-m-d H:i:s');

            if ($this->menu->update($id, $dados_save)) {
                $this->session->set_flashdata('msg_sistema', 'Menu salvo com sucesso.');
                redirect('admin/menus');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o menu.');
                redirect('admin/menus');
            }
        }
    }

    public function delete($id = null)
    {
        if ($id == null) {
            $this->session->set_flashdata('msg_sistema', 'Menu inexistente.');
            redirect('admin/menus');
        }
        if ($this->menu->delete($id)) {
            $this->load->model('menu_item');
            if($this->menu_item->delete_by_menu($id)) {
                $this->session->set_flashdata('msg_sistema', 'Menu excluído com sucesso.');
                redirect('admin/menus');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Menu excluído com sucesso, porém os itens do menu não foram excluídos.');
                redirect('admin/menus');
            }
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o menu.');
            redirect('admin/menus');
        }
    }

}
