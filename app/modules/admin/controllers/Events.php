<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Events class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Events extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'post';
        $this->language_file = 'wpn_event_lang';
        parent::__construct();
    }

    /**
     * Events list.
     */
    public function index()
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_title'), wpn_lang('field_created_on'), wpn_lang('field_status'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->post->count_by(array('page' => 2, 'deleted' => '0'));
        $config = array();
        $config['base_url'] = site_url('admin/events/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->post->limit($limit, $offset)
                            ->order_by('created_on', 'desc')
                            ->where('page', 2)
                            ->select('id, title, created_on, status')
                            ->find_all();
        
        //$query = $this->post->where('page', '2')->order_by('created_on', 'desc')->find_all();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->title, mdate(config_item('user_date_format'), strtotime($row->created_on, false)), status_post($row->status),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/events/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/events/delete/' . $row->id, glyphicon('trash') ,array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                    div(null, true)
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * New event.
     */
    public function add()
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        $this->form_validation->set_rules('created', wpn_lang('field_created_on'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
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
            $data['created_on'] = datetime_for_mysql($this->input->post('created') . ' 12:00:00');
            $data['image'] = $this->wpanel->upload_media('capas', '*', 'userfile', date('YmdHis'));
            // Identifica se é uma página ou uma postagem
            // 0=post, 1=Página, 2=Agenda
            $data['page'] = '2';
            if ($this->post->insert($data))
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/events');
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/events');
        }
    }

    /**
     * Edit an event.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        $this->form_validation->set_rules('created', wpn_lang('field_created_on'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/events');
            $query = $this->post->find_by(array('id' => $id, 'page' => 2));
            if(count($query) == 0)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/events');
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
            $data['created_on'] = datetime_for_mysql($this->input->post('created') . ' 12:00:00');
            // Identifica se é uma página ou uma postagem
            // 0=post, 1=Página, 2=Agenda
            $data['page'] = '2';
            if ($this->input->post('alterar_imagem') == '1')
            {
                $postagem = $this->post->find($id);
                $this->wpanel->remove_media('capas/' . $postagem->image);
                $data['image'] = $this->wpanel->upload_media('capas', '*', 'userfile', date('YmdHis'));
            }
            if ($this->post->update($id, $data))
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/events');
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/events');
        }
    }

    /**
     * Delete an event.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/events');
        $this->load->model('post');
        $postagem = $this->post->find($id);
        $this->wpanel->remove_media('capas/' . $postagem->image);
        if ($this->post->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/events');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/events');
    }

}
