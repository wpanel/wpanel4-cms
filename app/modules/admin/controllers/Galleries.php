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
class Galleries extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('gallery', 'picture');
        $this->language_file = 'wpn_gallery_lang';
        parent::__construct();
    }

    /**
     * List of galleries.
     */
    public function index()
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_folder'), wpn_lang('field_title'), wpn_lang('field_created_on'), wpn_lang('field_status'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->gallery->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/galleries/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->gallery->limit($limit, $offset)
                            //->order_by('sequence', 'asc')
                            ->select('id, titulo, capa, created_on, status')
                            ->find_all();
        
        //$query = $this->gallery->find_all();
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
                    $row->id, $capa, anchor('admin/galleries/pictures/' . $row->id, glyphicon('picture') . $row->titulo), mdate(config_item('user_date_format'), strtotime($row->created_on)), status_post($row->status), div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/galleries/pictures/' . $row->id, glyphicon('picture'), array('class' => 'btn btn-default')) .
                    anchor('admin/galleries/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    anchor('admin/galleries/delete/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                    div(null, true)
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * New gallery.
     */
    public function add()
    {
        $this->form_validation->set_rules('titulo', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['tags'] = $this->input->post('tags');
            $data['status'] = $this->input->post('status');
            $data['capa'] = $this->wpanel->upload_media('capas');
            $new_post = $this->gallery->insert($data);
            mkdir('./media/albuns/' . $new_post);
            if ($new_post)
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/galleries');
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/galleries');
        }
    }

    /**
     * Edit an gallery.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $this->form_validation->set_rules('titulo', wpn_lang('field_title'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/galleries');
            $this->set_var('id', $id);
            $this->set_var('row', $this->gallery->find($id));
            $this->render();
        } else
        {
            $data = array();
            $data['titulo'] = $this->input->post('titulo');
            $data['descricao'] = $this->input->post('descricao');
            $data['tags'] = $this->input->post('tags');
            $data['status'] = $this->input->post('status');
            if ($this->input->post('alterar_imagem') == '1')
            {
                $query = $this->gallery->find($id);
                $this->wpanel->remove_media('capas/' . $query->capa);
                $data['capa'] = $this->wpanel->upload_media('capas');
            }
            $new_post = $this->gallery->update($id, $data);
            if ($new_post)
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/galleries');
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/galleries');
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
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/galleries');

        $this->picture->delete_by_album($id);
        $query = $this->gallery->find($id);
        $this->wpanel->remove_media('capas/' . $query->capa);
        if ($this->gallery->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/galleries');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/galleries');
    }

    /**
     * List the pictures from a Gallery.
     *
     * @param int $album_id
     */
    public function pictures($album_id)
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(
            array('table_open' => '<table id="grid" class="table table-condensed table-striped">')
        );
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_filename'), wpn_lang('field_description'), wpn_lang('field_created_on'), wpn_lang('field_status'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 6;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->picture->count_by(array('album_id' => $album_id, 'deleted' => '0'));
        $config = array();
        $config['base_url'] = site_url('admin/galleries/pictures/'.$album_id.'/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->picture->limit($limit, $offset)
                            ->order_by('created_on', 'desc')
                            ->select('id, filename, descricao, created_on, status')
                            ->find_many_by('album_id', $album_id);

        foreach ($query as $row)
        {
            $capa_properties = array(
                'src' => base_url() . '/media/albuns/' . $album_id . '/' . $row->filename,
                'class' => 'img-responsive',
                'width' => '120',
                'alt' => $row->descricao
            );
            $imagem = img($capa_properties);
            $this->table->add_row(
                $row->id, $imagem, $row->descricao, mdate(config_item('user_date_format'), strtotime($row->created_on)), status_post($row->status), div(array('class' => 'btn-group btn-group-xs')) .
                anchor('admin/galleries/editpicture/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                anchor('admin/galleries/delpicture/' . $row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'data-confirm' => 'Deseja mesmo excluir esta imagem? Esta ação não poderá ser desfeita.')) .
                div(null, true)
            );
        }
        
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('album_id', $album_id);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert pictures.
     *
     * @param int $album_id
     */
    public function addpicture($album_id)
    {
        $this->form_validation->set_rules('descricao', wpn_lang('field_description'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->set_var('album_id', $album_id);
            $this->render();
        } else
        {
            $data = array();
            $data['album_id'] = $album_id;
            $data['descricao'] = $this->input->post('descricao');
            $data['status'] = $this->input->post('status');
            $data['filename'] = $this->wpanel->upload_media('albuns/' . $album_id);
            $new_post = $this->picture->insert($data);
            if ($new_post)
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/galleries/pictures/' . $album_id);
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/galleries/pictures/' . $album_id);
        }
    }

    /**
     * Add pictures in bach.
     *
     * @param int $album_id
     */
    public function addmass($album_id = null)
    {
        if ($album_id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/galleries');

        $this->form_validation->set_rules('descricao', wpn_lang('field_description'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->set_var('album_id', $album_id);
            $this->render();
        } else
        {
            /* Faz o laço do upload */
            $pasta = FCPATH . 'media/albuns/' . $album_id . '/';
            $pictures = $_FILES['pictures'];
            for ($i = 0; $i < sizeof($pictures['name']); $i++)
            {
                // Desmembra o nome para eliminar os caracteres especiais e recolocar a extensão.
                $x = explode('.', $pictures["name"][$i]);
                $nome = $album_id . '_' . time() . '_' . strtolower(url_title(convert_accented_characters($x[0])));
                $extensao = $x[1];
                $tmpname = $pictures["tmp_name"][$i];
                $caminho = $pasta . $nome . '.' . $extensao;
                if (move_uploaded_file($tmpname, $caminho))
                {
                    $data = array();
                    $data['album_id'] = $album_id;
                    $data['descricao'] = $this->input->post('descricao');
                    $data['status'] = $this->input->post('status');
                    $data['filename'] = $nome . '.' . $extensao;
                    $uploads = $this->picture->insert($data);
                } else
                    $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/galleries/pictures/' . $album_id);
            }
            /* Fim do laço do upload */
            $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/galleries/pictures/' . $album_id);
        }
    }

    /**
     * Edit an picture.
     *
     * @param int $id
     */
    public function editpicture($id = null)
    {
        $row = $this->picture->find($id);
        $this->form_validation->set_rules('descricao', wpn_lang('field_description'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/galleries');
            $this->set_var('id', $id);
            $this->set_var('row', $row);
            $this->render();
        } else
        {
            $data['descricao'] = $this->input->post('descricao');
            $data['status'] = $this->input->post('status');
            if ($this->input->post('alterar_imagem') == '1')
            {
                $query = $this->picture->find($id);
                $this->wpanel->remove_media('albuns/' . $query->album_id . '/' . $query->filename);
                $data['filename'] = $this->wpanel->upload_media('albuns/' . $query->album_id . '/');
            }
            if ($this->picture->update($id, $data))
                $this->set_message(wpn_lang('wpn_message_update_success'), 'success', 'admin/galleries/pictures/' . $row->album_id);
            else
                $this->set_message(wpn_lang('wpn_message_update_error'), 'danger', 'admin/galleries/pictures/' . $row->album_id);
        }
    }

    /**
     * Delete an picture.
     *
     * @param int $id
     */
    public function delpicture($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/galleries');
        $qry_picture = $this->picture->find($id);
        $this->wpanel->remove_media('albuns/' . $qry_picture->album_id . '/' . $qry_picture->filename);
        if ($this->picture->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/galleries/pictures/' . $qry_picture->album_id);
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/galleries/pictures/' . $qry_picture->album_id);
    }

}
