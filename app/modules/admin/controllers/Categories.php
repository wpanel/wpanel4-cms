<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Este é o controller de categorias, usado principalmente
 * no painel de controle do site.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Categories extends Authenticated_admin_controller
{

    function __construct()
    {
        $this->model_file = 'category';
        $this->language_file = 'wpn_category_lang';
        parent::__construct();
    }

    /**
     * List of categories.
     */
    public function index()
    {
        $this->load->library('table');
        $posts_views = config_item('posts_views');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_title'), wpn_lang('field_category'), wpn_lang('field_view'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->category->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/categories/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->category->limit($limit, $offset)
                            ->select('id, title, category_id, view')
                            ->find_all();
        
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->title, $this->category->get_title_by_id($row->category_id), $posts_views[$row->view], div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/categories/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/categories/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                    div(null, true)
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert new category.
     */
    public function add()
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // Prepara a lista de categorias.
            $query = $this->category->find_all();
            $options = array();
            $options[0] = 'Sem categoria';
            foreach ($query as $row)
            {
                $options[$row->id] = $row->title;
            }
            $this->set_var('options', $options);
            $this->render();
        } else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['link'] = url_title(convert_accented_characters($this->input->post('title')));
            $data['category_id'] = $this->input->post('category_id');
            $data['view'] = $this->input->post('view');
            if ($this->category->insert($data))
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/categories');
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/categories');
        }
    }

    /**
     * Edit an category.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('title', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/categories');
            // Prepara a lista de categorias.
            $query = $this->category->find_all();
            $options = array();
            $options[0] = 'Sem categoria';
            foreach ($query as $row)
            {
                $options[$row->id] = $row->title;
            }
            $this->set_var('row', $this->category->find($id));
            $this->set_var('options', $options);
            $this->render();
        } else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['link'] = url_title(convert_accented_characters($this->input->post('title')));
            $data['category_id'] = $this->input->post('category_id');
            $data['view'] = $this->input->post('view');
            if ($this->category->update($id, $data))
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/categories');
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/categories');
        }
    }

    /**
     * Delete an category.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/categories');
        if ($this->category->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/categories');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/categories');
    }

}
