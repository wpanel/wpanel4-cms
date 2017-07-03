<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu_itens class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Menuitens extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('menu_item', 'post', 'categoria', 'menu');
        parent::__construct();
    }

    /**
     * Index page forbidden.
     */
    public function index()
    {
        redirect('admin/menus');
    }

    /**
     * new menu item.
     * 
     * @param int $menu_id
     */
    public function add($menu_id)
    {
        $this->form_validation->set_rules('label', 'Label', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->set_var('menu_id', $menu_id);
            $this->set_var('posts', $this->post->find_all());
            $this->set_var('categorias', $this->categoria->find_all());
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
                $this->set_message('Item de menu salvo com sucesso!', 'success', 'admin/menus');
            else
                $this->set_message('Erro ao salvar o ítem de menu.', 'danger', 'admin/menus');
        }
    }

    /**
     * Edit an menu item.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('label', 'Label', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Item de menu inexistente.', 'info', 'admin/menus');
            $this->set_var('posts', $this->post->find_all());
            $this->set_var('categorias', $this->categoria->find_all());
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
                $this->set_message('Item de menu salvo com sucesso!', 'success', 'admin/menus');
            else
                $this->set_message('Erro ao salvar o ítem de menu.', 'danger', 'admin/menus');
        }
    }

    /**
     * Delete an menu item.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message('Item de menu inexistente.', 'info', 'admin/menus');
        if ($this->menu_item->delete($id))
            $this->set_message('Item de menu excluído com sucesso!', 'success', 'admin/menus');
        else
            $this->set_message('Erro ao excluir o ítem de menu.', 'danger', 'admin/menus');
    }

}
