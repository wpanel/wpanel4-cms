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
class Menus extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('menu', 'menu_item');
        parent::__construct();
    }

    /**
     * List of menus.
     */
    public function index()
    {
        $query_menu = $this->menu->find_all();
        $html_menu = "";
        foreach ($query_menu as $row)
        {
            $html_menu .= "<li class=\"list-group-item\"><div class=\"row\">";
            $html_menu .= "<div class=\"col-md-1 col-sm-1\"><b>[" . $row->id . "]</b></div>";
            $html_menu .= "<div class=\"col-md-9 col-sm-9\">" . $row->nome . "</div>";
            $html_menu .= "<div class=\"col-md-2 col-sm-2 btn-group btn-group-xs\">";
            $html_menu .= anchor('admin/menus/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default'));
            $html_menu .= '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/menus/delete/' .
                            $row->id) . '\');">' . glyphicon('trash') . '</button>';
            $html_menu .= "</div>";
            $html_menu .= "</div></li>";
            $html_menu .= "<li class=\"list-group-item\">";
            $html_menu .= $this->get_menu_item($row->id);
            $html_menu .= "</li>";
        }

        $this->set_var('listagem', $html_menu);
        $this->render();
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
        $this->table->set_heading('Label', 'Ordem', 'Tipo', 'Link', 'Ações');
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
                    anchor('admin/menuitens/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/menuitens/delete/' .
                            $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $data['menu_id'] = $menu_id;
        $data['listagem'] = $this->table->generate();
        return $this->load->view('menuitens/index', $data, TRUE);
    }

    /**
     * Return posts title.
     * 
     * @param int $post_link
     * @return string
     */
    private function get_titulo_postagem($post_link)
    {
        $this->load->model('post');
        $query = $this->post->find_by('link', $post_link);
        return $query->title;
    }

    /**
     * Return categories title.
     * 
     * @param int $categoria_id
     * @return string
     */
    private function get_titulo_categoria($categoria_id)
    {
        $this->load->model('categoria');
        $query = $this->categoria->find($categoria_id);
        return $query->title;
    }

    /**
     * return menu title.
     * 
     * @param int $menu_id
     * @return string
     */
    private function get_titulo_menu($menu_id)
    {
        $this->load->model('menu');
        $query = $this->menu->find($menu_id);
        return $query->nome;
    }

    /**
     * New menu.
     */
    public function add()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
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
                $this->set_message('Menu salvo com sucesso!', 'success', 'admin/menus');
            else
                $this->set_message('Erro ao salvar o menu.', 'danger', 'admin/menus');
        }
    }

    /**
     * Edit an menu.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Menu inexistente.', 'info', 'admin/menus');
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
                $this->set_message('Menu salvo com sucesso!', 'success', 'admin/menus');
            else
                $this->set_message('Erro ao salvar o menu.', 'danger', 'admin/menus');
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
            $this->set_message('Menu inexistente.', 'info', 'admin/menus');
        if ($this->menu->delete($id))
        {
            $this->menu_item->delete_by_menu($id);
            $this->set_message('Menu excluído com sucesso!', 'success', 'admin/menus');
        } else
            $this->set_message('Erro ao excluir o menu.', 'danger', 'admin/menus');
    }

}
