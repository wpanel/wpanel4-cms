<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class banners.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class banners extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'banner';
        parent::__construct();
    }

    /**
     * List of banners.
     */
    public function index()
    {
        $this->load->library('table');
        $layout_vars = array();
        $content_vars = array();
        $options = config_item('banner_positions');
        $query = $this->banner->order_by('sequence', 'asc')->find_all();
        $this->set_var('query', $query);
        $this->set_var('options', $options);
        $this->render();
    }

    /**
     * Create a new banner.
     */
    public function add()
    {
        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('sequence', 'Ordem', 'required');
        $this->form_validation->set_rules('position', 'Posição', 'required');
        if ($this->form_validation->run() == FALSE)
            $this->render();
        else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['sequence'] = $this->input->post('sequence');
            $data['position'] = $this->input->post('position');
            $data['status'] = $this->input->post('status');
            $data['content'] = $this->wpanel->upload_media('banners');
            if ($this->banner->insert($data))
                $this->set_message('Banner salvo com sucesso!', 'success', 'admin/banners');
            else
                $this->set_message('Erro ao salvar o banner.', 'damger', 'admin/banners');
        }
    }

    /**
     * Edit a banner.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('sequence', 'Ordem', 'required');
        $this->form_validation->set_rules('position', 'Posição', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Banner inexistente.', 'info', 'admin/banners');
            $this->set_var('id', $id);
            $this->set_var('row', $this->banner->find($id));
            $this->render();
        } else
        {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['sequence'] = $this->input->post('sequence');
            $data['position'] = $this->input->post('position');
            $data['status'] = $this->input->post('status');
            if ($this->input->post('alterar_imagem') == '1')
            {
                $banner = $this->banner->find($id);
                $this->wpanel->remove_media('banners/' . $banner->content);
                $data['content'] = $this->wpanel->upload_media('banners');
            }
            if ($this->banner->update($id, $data))
                $this->set_message('Banner salvo com sucesso!', 'success', 'admin/banners');
            else
                $this->set_message('Erro ao salvar o banner', 'danger', 'admin/banners');
        }
    }

    /**
     * Delete a banner.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message('Banner inexistente.', 'info', 'admin/banners');
        // Remove o arquivo do banner.
        $banner = $this->banner->find($id);
        $this->wpanel->remove_media('banners/' . $banner->content);
        if ($this->banner->delete($id))
            $this->set_message('Banner excluído com sucesso!', 'success', 'admin/banners');
        else
            $this->set_message('Erro ao excluir o banner', 'danger', 'admin/banners');
    }

}
