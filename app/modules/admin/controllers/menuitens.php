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
        $this->table->set_heading('#', 'Label', 'Tipo', 'Link', 'Ações');
        $query = $this->menu_item->get_list();

        foreach ($query->result() as $row)
        {
            $this->table->add_row(
                    $row->id, $row->label, $row->tipo, $row->href, div(array('class' => 'btn-group btn-group-sm')) .
                    anchor('admin/menuitens/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/menuitens/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'onClick' => 'return apagar();')) .
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
//        $this->form_validation->set_rules('link', 'Link', 'required');

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
            $dados_save['created'] = date('Y-m-d H:i:s');
            $dados_save['updated'] = date('Y-m-d H:i:s');
            // Verifica de onde vem os dados para o campo 'link'
            switch ($tipo_link)
            {
                case 'link':
                    $dados_save['href'] = $this->input->post('href');
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

        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('order', 'Ordem', 'required');
        $this->form_validation->set_rules('position', 'Posição', 'required');

        if ($this->form_validation->run() == FALSE) {

            if ($id == null) {
                $this->session->set_flashdata('msg_sistema', 'Banner inexistente.');
                redirect('admin/menuitens');
            }


            $content_vars['id'] = $id;
            $content_vars['row'] = $this->menu_item->get_by_id($id)->row();
            $layout_vars['content'] = $this->load->view('banners_edit', $content_vars, TRUE);
            $this->load->view('layout', $layout_vars);
        } else {



            $dados_save = array();
            $dados_save['title'] = $this->input->post('title');
            $dados_save['order'] = $this->input->post('order');
            $dados_save['position'] = $this->input->post('position');
            $dados_save['status'] = $this->input->post('status');
            $dados_save['updated'] = date('Y-m-d H:i:s');

            if ($this->input->post('alterar_imagem') == '1') {
                $this->remove_image($id);
                $dados_save['content'] = $this->upload();
            }

            $new_post = $this->menu_item->update($id, $dados_save);

            if ($new_post) {
                $this->session->set_flashdata('msg_sistema', 'Banner salvo com sucesso.');
                redirect('admin/menuitens');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar o banner.');
                redirect('admin/menuitens');
            }
        }
    }

    public function delete($id = null)
    {

        if ($id == null) {
            $this->session->set_flashdata('msg_sistema', 'Banner inexistente.');
            redirect('admin/menuitens');
        }



        $this->remove_image($id);

        if ($this->menu_item->delete($id)) {
            $this->session->set_flashdata('msg_sistema', 'Banner excluído com sucesso.');
            redirect('admin/menuitens');
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao excluir o banner.');
            redirect('admin/menuitens');
        }
    }

    private function upload()
    {

        $config['upload_path'] = './media/banners/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['remove_spaces'] = TRUE;
        $config['file_name'] = md5(date('YmdHis'));

        $this->load->library('upload', $config);

        if ($this->upload->do_upload()) {
            $upload_data = array();
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        } else {
            return false;
        }
    }

    /**
     * Este método faz a exclusão de uma imagem de banner.
     *
     * @return boolean
     * @param $id Integer ID do banner.
     * @author Eliel de Paula <elieldepaula@gmail.com>
     * */
    private function remove_image($id)
    {

        $banner = $this->menu_item->get_by_id($id)->row();
        $filename = './media/banners/' . $banner->content;
        if (file_exists($filename)) {
            if (unlink($filename)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
