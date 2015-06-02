<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menus extends MX_Controller {

    function __construct() {
        $this->auth->protect('admin');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        $this->load->model('menu');
    }

    public function index() {
        
        $this->load->library('table');

        $layout_vars = array();
        $content_vars = array();

        // Template da tabela
        $this->table->set_template(array('table_open' => '<table class="table table-striped">'));
        $this->table->set_heading('#', 'Título', 'Ações'); // 'Posição', 'Estilo',
        $query = $this->menu->get_list();

        foreach ($query->result() as $row) {
            $this->table->add_row( //$row->posicao, $row->estilo
                    $row->id, anchor('admin/menuitens/index/'.$row->id, $row->nome), div(array('class' => 'btn-group btn-group-sm')) .
                    anchor('admin/menus/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/menus/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'onClick' => 'return apagar();')) .
                    div(null, true)
            );
        }

        $content_vars['listagem'] = $this->table->generate();
        $layout_vars['content'] = $this->load->view('menus_index', $content_vars, TRUE);

        $this->load->view('layout', $layout_vars);
    }

    public function add() {
        
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        //$this->form_validation->set_rules('posicao', 'Posição', 'required');

        if ($this->form_validation->run() == FALSE) {
            $layout_vars['content'] = $this->load->view('menus_add', $content_vars, TRUE);
            $this->load->view('layout', $layout_vars);
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

    public function edit($id = null) {
        
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        //$this->form_validation->set_rules('posicao', 'Posição', 'required');

        if ($this->form_validation->run() == FALSE) {

            if ($id == null) {
                $this->session->set_flashdata('msg_sistema', 'Menu inexistente.');
                redirect('admin/menus');
            }

            $content_vars['id'] = $id;
            $content_vars['row'] = $this->menu->get_by_id($id)->row();
            $layout_vars['content'] = $this->load->view('menus_edit', $content_vars, TRUE);
            $this->load->view('layout', $layout_vars);
            
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

    public function delete($id = null) {

        if ($id == null) {
            $this->session->set_flashdata('msg_sistema', 'Menu inexistente.');
            redirect('admin/menus');
        }

        if ($this->menu->delete($id)) {
            $this->session->set_flashdata('msg_sistema', 'Menu excluído com sucesso.');
            redirect('admin/menus');
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o menu.');
            redirect('admin/menus');
        }
    }
}
