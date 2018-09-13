<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Video class
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Videos extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'video';
        $this->language_file = 'wpn_video_lang';
        parent::__construct();
    }

    /**
     * List videos.
     */
    public function index()
    {
        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_title'), wpn_lang('field_created_on'), wpn_lang('field_status'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->video->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/videos/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->video->limit($limit, $offset)
                            //->order_by('sequence', 'asc')
                            ->select('id, titulo, created_on, status')
                            ->find_all();
        
        //$query = $this->video->find_all();
        foreach ($query as $row)
        {
            $this->table->add_row(
                $row->id, $row->titulo, mdate(config_item('user_date_format'), strtotime($row->created_on)), status_post($row->status), div(array('class' => 'btn-group btn-group-xs')) .
                anchor('admin/videos/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                anchor('admin/videos/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                div(null, true)
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert video.
     */
    public function add()
    {
        $this->form_validation->set_rules('titulo', wpn_lang('field_title'), 'required');
        $this->form_validation->set_rules('link', wpn_lang('field_link'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['tags'] = $this->input->post('tags');
            $data['link'] = $this->get_youtube_code($this->input->post('link'));
            $data['status'] = $this->input->post('status');
            if ($this->video->insert($data))
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/videos');
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/videos');
        }
    }

    /**
     * Edit an video.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('titulo', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/videos');
            $this->set_var('row', $this->video->find($id));
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['tags'] = $this->input->post('tags');
            $data['link'] = $this->get_youtube_code($this->input->post('link'));
            $data['status'] = $this->input->post('status');
            if ($this->video->update($id, $data))
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/videos');
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/videos');
        }
    }

    /**
     * Delete an video.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/videos');
        if ($this->video->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/videos');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/videos');
    }

    /**
     * Return youtube code by an URI
     * 
     * @param string $url
     * @return string
     */
    private function get_youtube_code($url)
    {
        $ex = explode('?v=', $url);
        return $ex[1];
    }

    /* append-here */
}
