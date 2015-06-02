<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menuitens extends MX_Controller
{

    function __construct()
    {
        $this->auth->protect('admin');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        $this->load->model('menu_item');
    }

    public function index($menu_id)
    {

        $this->load->library('table');

        $layout_vars = array();
        $content_vars = array();

        // Template da tabela
        $this->table->set_template(array('table_open' => '<table class="table table-striped">'));
        $this->table->set_heading('Label', 'Ordem', 'Tipo', 'Link', 'Ações');
        $query = $this->menu_item->get_list(array('field'=>'ordem', 'order'=>'asc'));

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

            }

            $this->table->add_row(
                    $row->label, $row->ordem, humanize($row->tipo), $link, div(array('class' => 'btn-group btn-group-sm')) .
                    anchor('admin/menuitens/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/menuitens/delete/' . $menu_id . '/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'onClick' => 'return apagar();')) .
                    div(null, true)
            );
        }

        $content_vars['menu_id'] = $menu_id;
        $content_vars['listagem'] = $this->table->generate();
        $layout_vars['content'] = $this->load->view('menuitens_index', $content_vars, TRUE);

        $this->load->view('layout', $layout_vars);
    }

    public function add($menu_id)
    {

        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('label', 'Label', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->model('post');
            $this->load->model('categoria');
            $content_vars['menu_id'] = $menu_id;
            $content_vars['posts'] = $this->post->get_list()->result();
            $content_vars['categorias'] = $this->categoria->get_list()->result();
            $layout_vars['content'] = $this->load->view('menuitens_add', $content_vars, TRUE);
            $this->load->view('layout', $layout_vars);
        } else {
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
            }

            if ($this->menu_item->save($dados_save)) {
                $this->session->set_flashdata('msg_sistema', 'Item de menu salvo com sucesso.');
                redirect('admin/menuitens/index/' . $menu_id);
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o ítem de menu.');
                redirect('admin/menuitens/index/' . $menu_id);
            }
        }
    }

    public function edit($id = null)
    {
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('label', 'Label', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');

        if ($this->form_validation->run() == FALSE) {

            if ($id == null) {
                $this->session->set_flashdata('msg_sistema', 'Item de menu inexistente.');
                redirect('admin/menus');
            }

            $this->load->model('post');
            $this->load->model('categoria');

            $content_vars['posts'] = $this->post->get_list()->result();
            $content_vars['categorias'] = $this->categoria->get_list()->result();
            $content_vars['id'] = $id;
            $content_vars['row'] = $this->menu_item->get_by_id($id)->row();
            $layout_vars['content'] = $this->load->view('menuitens_edit', $content_vars, TRUE);
            $this->load->view('layout', $layout_vars);
        } else {

            $menu_id = $this->input->post('menu_id');
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
            }

            if ($this->menu_item->update($id, $dados_save)) {
                $this->session->set_flashdata('msg_sistema', 'Item de menu salvo com sucesso.');
                redirect('admin/menuitens/index/' . $menu_id);
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o item de menu.');
                redirect('admin/menuitens/index/' . $menu_id);
            }
        }
    }

    public function delete($menu_id, $id = null)
    {

        if ($id == null) {
            $this->session->set_flashdata('msg_sistema', 'Item de menu inexistente.');
            redirect('admin/menuitens/index/' . $menu_id);
        }

        if ($this->menu_item->delete($id)) {
            $this->session->set_flashdata('msg_sistema', 'Item de menu excluído com sucesso.');
            redirect('admin/menuitens/index/' . $menu_id);
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o item de menu.');
            redirect('admin/menuitens/index/' . $menu_id);
        }
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

}
