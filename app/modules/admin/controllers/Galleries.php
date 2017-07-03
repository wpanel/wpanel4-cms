<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gallety class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Galleries extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('gallery', 'picture');
        parent::__construct();
    }

    /**
     * List of galleries.
     */
    public function index()
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-striped">'));
        $this->table->set_heading('#', 'Capa', 'Título', 'Data', 'Status', 'Ações');
        $query = $this->gallery->find_all();
        foreach ($query as $row)
        {
            $capa_properties = array(
                'src' => base_url() . '/media/capas/' . $row->capa,
                'class' => 'img-responsive',
                'width' => '120',
                'alt' => $row->titulo
            );
            $capa = img($capa_properties);
            $this->table->add_row(
                    $row->id, $capa, anchor('admin/pictures/index/' . $row->id, glyphicon('picture') . $row->titulo), mdate('%d/%m/%Y - %H:%i', strtotime($row->created_on)), status_post($row->status), div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/pictures/index/' . $row->id, glyphicon('picture'), array('class' => 'btn btn-default')) .
                    anchor('admin/galleries/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' . site_url('admin/galleries/delete/' . $row->id) . '\');">' . glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * New gallery.
     */
    public function add()
    {
        $this->form_validation->set_rules('titulo', 'Título', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['status'] = $this->input->post('status');
            $data['capa'] = $this->wpanel->upload_media('capas');
            $new_post = $this->gallery->insert($data);
            mkdir('./media/albuns/' . $new_post);
            if ($new_post)
                $this->set_message('Álbum salvo com sucesso!', 'success', 'admin/galleries');
            else
                $this->set_message('Erro ao salvar o álbum.', 'danger', 'admin/galleries');
        }
    }

    /**
     * Edit an gallery.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('titulo', 'Título', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Álbum inexistente.', 'info', 'admin/galleries');
            $this->set_var('id', $id);
            $this->set_var('row', $this->gallery->find($id));
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['status'] = $this->input->post('status');
            if ($this->input->post('alterar_imagem') == '1')
            {
                $query = $this->gallery->find($id);
                $this->wpanel->remove_media('capas/' . $query->capa);
                $data['capa'] = $this->wpanel->upload_media('capas');
            }
            $new_post = $this->gallery->update($id, $data);
            if ($new_post)
                $this->set_message('Álbum salvo com sucesso!', 'success', 'admin/galleries');
            else
                $this->set_message('Erro ao salvar o álbum.', 'danger', 'admin/galleries');
        }
    }

    /**
     * Delete an gallery.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {

        if ($id == null)
            $this->set_message('Álbum inexistente.', 'info', 'admin/galleries');

        $this->picture->delete_by_album($id);
        $query = $this->gallery->find($id);
        $this->wpanel->remove_media('capas/' . $query->capa);
        if ($this->gallery->delete($id))
            $this->set_message('Álbum excluído com sucesso!', 'success', 'admin/galleries');
        else
            $this->set_message('Erro ao excluir o álbum.', 'danger', 'admin/galleries');
    }

}
