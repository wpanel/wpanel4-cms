<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu Class
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Menus extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('menu_item', 'post', 'category', 'menu');
        $this->language_file = 'wpn_menu_lang';
        parent::__construct();
    }

    /**
     * List of menus.
     */
    public function index()
    {
        $query_menu = $this->menu->find_all();
        $output = "";
        foreach ($query_menu as $row)
        {
            $output .= "<li class=\"list-group-item\"><div class=\"row\">";
            $output .= "<div class=\"col-md-1 col-sm-1\"><b>[" . $row->id . "]</b></div>";
            $output .= "<div class=\"col-md-9 col-sm-9\">" . $row->nome . "</div>";
            $output .= "<div class=\"col-md-2 col-sm-2 btn-group btn-group-xs\">";
            $output .= anchor('admin/menus/edit/'.$row->id, glyphicon('edit'), array('class' => 'btn btn-default'));
            $output .= anchor('admin/menus/delete/'.$row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm')));
            $output .= "</div>";
            $output .= "</div></li>";
            $output .= "<li class=\"list-group-item\">";
            $output .= $this->get_menu_item($row->id);
            $output .= "</li>";
        }

        $this->set_var('listagem', $output);
        $this->render();
    }

    /**
     * New menu.
     */
    public function add()
    {
        $this->form_validation->set_rules('nome', wpn_lang('field_nome'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->render();
        } else
        {
            $data = array();
            $data['nome'] = $this->input->post('nome');
            $data['slug'] = strtolower(url_title(convert_accented_characters($this->input->post('nome'))));
            $data['posicao'] = $this->input->post('posicao');
            $data['estilo'] = $this->input->post('estilo');
            if ($this->menu->insert($data))
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/menus');
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/menus');
        }
    }

    /**
     * Edit an menu.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('nome', wpn_lang('field_nome'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/menus');
            $this->set_var('id', $id);
            $this->set_var('row', $this->menu->find($id));
            $this->render();
        } else
        {
            $data = array();
            $data['nome'] = $this->input->post('nome');
            $data['slug'] = strtolower(url_title(convert_accented_characters($this->input->post('nome'))));
            $data['posicao'] = $this->input->post('posicao');
            $data['estilo'] = $this->input->post('estilo');
            if ($this->menu->update($id, $data))
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/menus');
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/menus');
        }
    }

    /**
     * Delete an menu.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/menus');
        if ($this->menu->delete($id))
        {
            $this->menu_item->delete_by_menu($id);
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/menus');
        } else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/menus');
    }

    /**
     * new menu item.
     * 
     * @param int $menu_id
     */
    public function additem($menu_id)
    {
        $this->form_validation->set_rules('label', wpn_lang('field_label'), 'required');
        $this->form_validation->set_rules('tipo', wpn_lang('field_type'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->set_var('menu_id', $menu_id);
            $this->set_var('posts', $this->post->find_all());
            $this->set_var('categorias', $this->category->find_all());
            $this->set_var('menus', $this->menu->find_all());
            $this->render();
        } else
        {
            $tipo_link = $this->input->post('tipo');
            $data = array();
            $data['menu_id'] = $menu_id;
            $data['label'] = $this->input->post('label');
            $data['tipo'] = $tipo_link;
            $data['slug'] = '';
            $data['ordem'] = $this->input->post('ordem');
            $data['target'] = $this->input->post('target');
            // Verifica de onde vem os dados para o campo 'link'
            switch ($tipo_link)
            {
                case 'link':
                    $data['href'] = $this->input->post('link');
                    break;
                case 'post':
                    $data['href'] = $this->input->post('post_id');
                    break;
                case 'posts':
                    $data['href'] = $this->input->post('categoria_id');
                    break;
                case 'funcional':
                    $data['href'] = $this->input->post('funcional');
                    break;
                case 'submenu':
                    $data['href'] = $this->input->post('submenu');
                    break;
            }

            if ($this->menu_item->insert($data))
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/menus');
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/menus');
        }
    }

    /**
     * Edit an menu item.
     * 
     * @param int $id
     */
    public function edititem($id = null)
    {
        $this->form_validation->set_rules('label', wpn_lang('field_label'), 'required');
        $this->form_validation->set_rules('tipo', wpn_lang('field_type'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/menus');
            $this->set_var('posts', $this->post->find_all());
            $this->set_var('categorias', $this->category->find_all());
            $this->set_var('menus', $this->menu->find_all());
            $this->set_var('id', $id);
            $this->set_var('row', $this->menu_item->find($id));
            $this->render();
        } else
        {
            $tipo_link = $this->input->post('tipo');
            $data = array();
            $data['label'] = $this->input->post('label');
            $data['tipo'] = $tipo_link;
            $data['slug'] = '';
            $data['ordem'] = $this->input->post('ordem');
            $data['target'] = $this->input->post('target');
            // Verifica de onde vem os dados para o campo 'link'
            switch ($tipo_link)
            {
                case 'link':
                    $data['href'] = $this->input->post('link');
                    break;
                case 'post':
                    $data['href'] = $this->input->post('post_id');
                    break;
                case 'posts':
                    $data['href'] = $this->input->post('categoria_id');
                    break;
                case 'funcional':
                    $data['href'] = $this->input->post('funcional');
                    break;
                case 'submenu':
                    $data['href'] = $this->input->post('submenu');
                    break;
            }
            if ($this->menu_item->update($id, $data))
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/menus');
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/menus');
        }
    }

    /**
     * Delete an menu item.
     * 
     * @param int $id
     */
    public function deleteitem($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/menus');
        if ($this->menu_item->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/menus');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/menus');
    }

    /**
     * Return the menu items.
     * 
     * @param int $menu_id
     * @return mixed
     */
    private function get_menu_item($menu_id)
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table class="table table-striped table-bordered">'));
        $this->table->set_heading(wpn_lang('field_label'), wpn_lang('field_order'), wpn_lang('field_type'), wpn_lang('field_link'), wpn_lang('wpn_actions'));
        $query = $this->menu_item->order_by('ordem', 'asc')->find_many_by('menu_id', $menu_id);
        foreach ($query as $row)
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
                anchor('admin/menus/edititem/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                anchor('admin/menus/deleteitem/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                div(null, true)
            );
        }
        $data['menu_id'] = $menu_id;
        $data['listagem'] = $this->table->generate();
        return $this->load->view('menus/itemlist', $data, TRUE);
    }

    /**
     * Return posts title.
     * 
     * @param int $post_link
     * @return string
     */
    private function get_titulo_postagem($post_link)
    {
        $query = $this->post->find_by('link', $post_link);
        if(@count($query) > 0)
            return $query->title;
        else
            return '<span class="label label-danger">Error</span>';
    }

    /**
     * Return categories title.
     * 
     * @param int $categoria_id
     * @return string
     */
    private function get_titulo_categoria($categoria_id)
    {
        $query = $this->category->find($categoria_id);
        if(@count($query))
            return $query->title;
        else
            return '<span class="label label-danger">Error</span>';
    }

    /**
     * Return menu title.
     * 
     * @param int $menu_id
     * @return string
     */
    private function get_titulo_menu($menu_id)
    {
        $query = $this->menu->find($menu_id);
        if(!empty($query))
            return $query->nome;
        else
            return '<span class="label label-danger">Error</span>';
    }

}
