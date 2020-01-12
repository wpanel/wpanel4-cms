<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Page class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Pages extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'post';
        $this->language_file = 'wpn_page_lang';
        parent::__construct();
    }

    /**
     * List pages.
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
        $total_rows = $this->post->count_by(array('page' => 1, 'deleted' => '0'));
        $config = array();
        $config['base_url'] = site_url('admin/pages/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->post->limit($limit, $offset)
                            ->order_by('created_on', 'desc')
                            ->where('page', 1)
                            ->select('id, title, created_on, status')
                            ->find_all();
        
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->title, mdate(config_item('user_date_format'), strtotime($row->created_on)), status_post($row->status),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/pages/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/pages/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))).
                    div(null, true)
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert page.
     */
    public function add()
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
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
            $data['page'] = '1';
            if ($this->post->insert($data))
            {
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/pages');
            } else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/pages');
        }
    }

    /**
     * Edit an page.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Página inexistente.', 'info', 'admin/pages');
            $query = $this->post->find_by(array('id' => $id, 'page' => 1));
            if(empty($query))
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/pages');
            $this->set_var('id', $id);
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
            $data['page'] = '1';
            if ($this->input->post('alterar_imagem') == '1')
            {
                $postagem = $this->post->find($id);
                $this->wpanel->remove_media('capas/' . $postagem->image);
                $data['image'] = $this->wpanel->upload_media('capas');
            }
            if ($this->post->update($id, $data))
            {
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/pages');
            } else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/pages');
        }
    }

    /**
     * Delete an page.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/pages');
        $postagem = $this->post->find($id);
        $this->wpanel->remove_media('capas/' . $postagem->image);
        if ($this->post->delete($id))
        {
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/pages');
        } else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/pages');
    }

}
