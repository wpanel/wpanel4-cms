<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pposts class
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Posts extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('post', 'category', 'post_categoria');
        $this->language_file = 'wpn_post_lang';
        parent::__construct();
    }

    /**
     * List posts.
     */
    public function index()
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(
                '#', wpn_lang('field_title'), wpn_lang('field_created_on'), wpn_lang('field_status'), wpn_lang('wpn_actions')
        );

        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->post->count_by(array('page' => 0, 'deleted' => '0'));
        $config = array();
        $config['base_url'] = site_url('admin/posts/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação

        $query = $this->post->limit($limit, $offset)
                            ->order_by('created_on', 'desc')
                            ->where('page', 0)
                            ->select('id, title, created_on, status')
                            ->find_all();

        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->title . '<br/><small>' . $this->widget->load('wpncategoryfrompost', array('post_id' => $row->id)) . '</small>', mdate(config_item('user_date_format'), strtotime($row->created_on)), status_post($row->status),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/posts/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/posts/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))).
                    div(null, true)
            );
        }

        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert post.
     */
    public function add()
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // Prepara a lista de categorias.
            $query = $this->category->select('id, title')->find_all();
            $categorias = array();
            foreach ($query as $row)
            {
                $categorias[$row->id] = $row->title;
            }
            $this->set_var('categorias', $categorias);
            $this->render();
        } else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['link'] = strtolower(url_title(convert_accented_characters($this->input->post('title')))) . '-' . time();
            $data['content'] = $this->input->post('content');
            $data['tags'] = $this->input->post('tags');
            $data['status'] = $this->input->post('status');
            $data['image'] = $this->wpanel->upload_media('capas');
            // Identifica se é uma página ou uma postagem
            // 0=post, 1=Página
            $data['page'] = '0';
            $new_post = $this->post->insert($data);
            if ($new_post)
            {
                // Salva o relacionamento das categorias
                foreach ($this->input->post('category_id') as $cat_id)
                {
                    $cat_save = array();
                    $cat_save['post_id'] = $new_post;
                    $cat_save['category_id'] = $cat_id;
                    $this->post_categoria->insert($cat_save);
                }
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/posts');
            } else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/posts');
        }
    }

    /**
     * Edit an post.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/posts');
            $query = $this->post->find_by(array('id' => $id, 'page' => 0));
            if(empty($query))
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/posts');
            // Prepara a lista de categorias.
            $query_cat = $this->category->select('id, title')->find_all();
            $categorias = array();
            foreach ($query_cat as $row)
            {
                $categorias[$row->id] = $row->title;
            }
            // Prepara as categorias selecionadas.
            $query_selected_cat = $this->post_categoria->select('category_id')->find_many_by('post_id', $id);
            $cat_select = array();
            foreach ($query_selected_cat as $x => $row)
            {
                $cat_select[$x] = $row->category_id;
            }
            $this->set_var('id', $id);
            $this->set_var('categorias', $categorias);
            $this->set_var('cat_select', $cat_select);
            $this->set_var('row', $query);
            $this->render();
        } else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['link'] = strtolower(url_title(convert_accented_characters($this->input->post('title'))));
            $data['content'] = $this->input->post('content');
            $data['tags'] = $this->input->post('tags');
            $data['status'] = $this->input->post('status');
            // Identifica se é uma página ou uma postagem
            // 0=post, 1=Página
            $data['page'] = '0';
            if ($this->input->post('alterar_imagem') == '1')
            {
                $postagem = $this->post->find($id);
                $this->wpanel->remove_media('capas/' . $postagem->image);
                $data['image'] = $this->wpanel->upload_media('capas');
            }
            $upd_post = $this->post->update($id, $data);
            if ($upd_post)
            {
                // Apaga os relacionamentos anteriores.
                $this->post_categoria->delete_by_post($id);
                // Cadastra as alterações.
                foreach ($this->input->post('category_id') as $cat_id)
                {
                    $cat_save = array();
                    $cat_save['post_id'] = $id;
                    $cat_save['category_id'] = $cat_id;
                    $this->post_categoria->insert($cat_save);
                }
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/posts');
            } else
                $this->set_message(wpn_lang('wpn_message_update_success'), 'danger', 'admin/posts');
        }
    }

    /**
     * Delete an post.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/posts');
        $postagem = $this->post->find($id);
        $this->wpanel->remove_media('capas/' . $postagem->image);
        if ($this->post->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/posts');
        else
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'danger', 'admin/posts');
    }

}
