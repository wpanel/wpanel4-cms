<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Class banners.
 *
 * @todo Traduzir os status e posições dos banners.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Banners extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'banner';
        $this->language_file = 'wpn_banner_lang';
        parent::__construct();
    }

    /**
     * List of banners.
     */
    public function index()
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_title'), wpn_lang('field_position'), wpn_lang('field_status'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->banner->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/banners/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->banner->limit($limit, $offset)
                            ->order_by('sequence', 'asc')
                            ->select('id, title, href, position, created_on, status')
                            ->find_all();
        
        foreach ($query as $row) {
            $this->table->add_row(
                $row->id,
                $row->title . ($row->href ? ' ' . glyphicon('link'):''),
                wpn_lang('position_' . $row->position),
                status_label($row->status),
                // Ícones de ações
                div(array('class' => 'btn-group btn-group-xs')) .
                anchor('admin/banners/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                anchor('admin/banners/delete/' . $row->id, glyphicon('trash') ,array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                div(null, true)
            );
        }

        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Create a new banner.
     */
    public function add()
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        $this->form_validation->set_rules('sequence', wpn_lang('field_sequence'), 'required');
        $this->form_validation->set_rules('position', wpn_lang('field_position'), 'required');
        if (!$this->form_validation->run()) {
            $this->set_var('options', $this->get_prepared_options());
            $this->render();
        } else {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['href'] = $this->input->post('href');
            $data['target'] = $this->input->post('target');
            $data['sequence'] = $this->input->post('sequence');
            $data['position'] = $this->input->post('position');
            $data['status'] = $this->input->post('status');
            $data['content'] = $this->wpanel->upload_media('banners');
            if ($this->banner->insert($data)) {
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/banners');
            } else {
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/banners');
            }
        }
    }

    /**
     * Edit a banner.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        $this->form_validation->set_rules('sequence', wpn_lang('field_sequence'), 'required');
        $this->form_validation->set_rules('position', wpn_lang('field_position'), 'required');
        if (!$this->form_validation->run()) {
            if ($id == null) {
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/banners');
            }
            $this->set_var('options', $this->get_prepared_options());
            $this->set_var('id', $id);
            $this->set_var('row', $this->banner->find($id));
            $this->render();
        } else {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['href'] = $this->input->post('href');
            $data['target'] = $this->input->post('target');
            $data['sequence'] = $this->input->post('sequence');
            $data['position'] = $this->input->post('position');
            $data['status'] = $this->input->post('status');
            if ($this->input->post('alterar_imagem') == '1') {
                $banner = $this->banner->find($id);
                $this->wpanel->remove_media('banners/' . $banner->content);
                $data['content'] = $this->wpanel->upload_media('banners');
            }
            if ($this->banner->update($id, $data)) {
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/banners');
            } else {
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/banners');
            }
        }
    }

    /**
     * Delete a banner.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null) {
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/banners');
        }
        // Remove o arquivo do banner.
        $banner = $this->banner->find($id);
        $this->wpanel->remove_media('banners/' . $banner->content);
        if ($this->banner->delete($id)) {
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/banners');
        } else {
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/banners');
        }
    }

    /**
     * Return an array of banner positions with translate.
     *
     * @return array
     */
    private function get_prepared_options()
    {
        $config_options = config_item('banner_positions');
        $options = array();
        foreach ($config_options as $option) {
            $options[$option] = wpn_lang('position_' . $option);
        }
        return $options;
    }

}
