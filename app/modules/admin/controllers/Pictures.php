<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Picture class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
 */
class Pictures extends Authenticated_Controller
{

    /**
     * Class costructor.
     */
    function __construct()
    {
        $this->model_file = array('gallery', 'picture');
        parent::__construct();
    }

    /**
     * List pictures.
     * 
     * @param int $album_id
     */
    public function index($album_id)
    {
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(
                array('table_open' => '<table id="grid" class="table table-striped">')
        );
        $this->table->set_heading('#', 'Imagem', 'Descricao', 'Data', 'Status', 'Ações');
        $query = $this->picture->order_by('created_on', 'desc')->find_many_by('album_id', $album_id);
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
                    $row->id, $imagem, $row->descricao, mdate('%d/%m/%Y - %H:%i', strtotime($row->created_on)), status_post($row->status), div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/pictures/edit/' . $row->id, glyphicon('edit'), array('class' => 'btn btn-default')) .
                    '<button class="btn btn-default" onClick="return confirmar(\'' .
                    site_url('admin/pictures/delete/' . $row->id) . '\');">' .
                    glyphicon('trash') . '</button>' .
                    div(null, true)
            );
        }
        $this->set_var('album_id', $album_id);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert pictures.
     * 
     * @param int $album_id
     */
    public function add($album_id)
    {
        $this->form_validation->set_rules('descricao', 'Foto', 'required');
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
                $this->set_message('Foto salva com sucesso!', 'success', 'admin/pictures/index/' . $album_id);
            else
                $this->set_message('Erro ao salvar a foto.', 'danger', 'admin/pictures/index/' . $album_id);
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
            $this->set_message('Álbum de fotos inexistente.', 'info', 'admin/pictures/index/' . $album_id);
        $this->form_validation->set_rules('descricao', 'Foto', 'required');
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
                    $this->set_message('Não foi possível enviar as fotos.', 'danger', 'admin/pictures/index/' . $album_id);
            }
            /* Fim do laço do upload */
            $this->set_message('Fotos salvas com sucesso!', 'success', 'admin/pictures/index/' . $album_id);
        }
    }

    /**
     * Edit an picture.
     * 
     * @param int $id
     */
    public function edit($id = null)
    {
        $row = $this->picture->find($id);
        $this->form_validation->set_rules('descricao', 'Descrição', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            if ($id == null)
                $this->set_message('Foto inexistente.', 'info', 'admin/pictures');
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
                $this->set_message('Foto salva com sucesso!', 'success', 'admin/pictures/index/' . $row->album_id);
            else
                $this->set_message('Erro ao salvar a foto.', 'danger', 'admin/pictures/index/' . $row->album_id);
        }
    }

    /**
     * Delete an picture.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message('Foto inexistente', 'info', 'admin/pictures');
        $qry_picture = $this->picture->find($id);
        $this->wpanel->remove_media('albuns/' . $qry_picture->album_id . '/' . $qry_picture->filename);
        if ($this->picture->delete($id))
            $this->set_message('Foto excluída com sucesso!', 'success', 'admin/pictures/index/' . $qry_picture->album_id);
        else
            $this->set_message('Erro ao excluir a foto.', 'danger', 'admin/pictures/index/' . $qry_picture->album_id);
    }

}
