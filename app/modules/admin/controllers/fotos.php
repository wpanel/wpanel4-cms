<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fotos extends MX_Controller {
	
	function __construct()
	{
		$this->auth->protect('admin');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index($album_id)
	{
		$this->load->model('album');
		$this->load->model('foto');
		$this->load->library('table');

		$layout_vars = array();
		$content_vars = array();

		// Dados do álbum
		// $query_album = $this->album->get_by_id($album_id)->row();

		// Template da tabela
		$this->table->set_template(array('table_open'  => '<table class="table table-striped">')); 
		$this->table->set_heading('#', 'Imagem', 'Descricao', 'Data', 'Status', 'Ações');
		$query = $this->foto->get_by_field('album_id', $album_id, array('field'=>'created', 'order'=>'desc'));

		foreach($query->result() as $row)
		{

			$capa_properties = array(
            	'src' => base_url() . '/media/albuns/'.$album_id . '/' . $row->filename,
            	'class' => 'img-responsive',
            	'width' => '120',
            	'alt' => $row->descricao
            );
            $imagem = img($capa_properties);

			$this->table->add_row(
				$row->id, 
				$imagem, 
				$row->descricao, 
				mdate('%d/%m/%Y - %H:%i', strtotime($row->created)),
				status_post($row->status), 
				div(array('class'=>'btn-group btn-group-sm')).
				anchor('admin/fotos/edit/'.$row->id, glyphicon('edit'), array('class' => 'btn btn-default')).
				anchor('admin/fotos/delete/'.$row->id, glyphicon('trash'), array('class' => 'btn btn-default', 'onClick'=>'return apagar();')).
				div(null,true)
				);
		}

		$content_vars['album_id'] = $album_id;
		$content_vars['listagem'] = $this->table->generate();
		$layout_vars['content'] = $this->load->view('fotos_index', $content_vars, TRUE);

		$this->load->view('layout', $layout_vars);
	}	

	public function add($album_id)
	{
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('descricao', 'Foto', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$content_vars['album_id'] = $album_id;
			$layout_vars['content'] = $this->load->view('fotos_add', $content_vars, TRUE);
			$this->load->view('layout', $layout_vars);
		} else {

			$this->load->model('foto');

			$dados_save = array();
			$dados_save['album_id'] = $album_id;
			$dados_save['descricao'] = $this->input->post('descricao');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['created'] = date('Y-m-d H:i:s');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['filename'] = $this->upload($album_id);

			$new_post = $this->foto->save($dados_save);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Foto salva com sucesso.');
				redirect('admin/fotos/index/'.$album_id);
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar a foto.');
				redirect('admin/fotos/index/'.$album_id);
			}
		}
	}	

	public function edit($id = null)
	{
		$layout_vars = array();
		$content_vars = array();

		$this->load->model('foto');
		$row = $this->foto->get_by_id($id)->row();

		$this->form_validation->set_rules('descricao', 'Descrição', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Foto inexistente.');
				redirect('admin/albuns');
			}

			$content_vars['id'] = $id;
			$content_vars['row'] = $row;
			$layout_vars['content'] = $this->load->view('fotos_edit', $content_vars, TRUE);
			$this->load->view('layout', $layout_vars);

		} else {

			$dados_save['descricao'] = $this->input->post('descricao');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			
			if($this->input->post('alterar_imagem')=='1')
			{
				$this->remove_image($id);
				$dados_save['filename'] = $this->upload($row->album_id);
			}

			$new_post = $this->foto->update($id, $dados_save);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Foto salva com sucesso.');
				redirect('admin/fotos/index/'.$row->album_id);
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar a foto.');
				redirect('admin/fotos/index/'.$row->album_id);
			}
		}
	}	

	public function delete($id = null)
	{

		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Foto inexistente.');
			redirect('admin/albuns');
		}

		$this->load->model('foto');
		$qry_foto = $this->foto->get_by_id($id)->row();
		$this->remove_image($id);

		if($this->foto->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Foto excluída com sucesso.');
			redirect('admin/fotos/index/'.$qry_foto->album_id);
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir a foto.');
			redirect('admin/fotos/index/'.$qry_foto->album_id);
		}
	}

	private function upload($album_id)
	{

		$config['upload_path'] = './media/albuns/'.$album_id.'/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2000';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['remove_spaces'] = TRUE;
		$config['file_name'] = md5(date('YmdHis'));

		$this->load->library('upload', $config);

		if ($this->upload->do_upload())
		{
			$upload_data = array();
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];
		} else {
			return false;
		}
	}

	/**
	 * Este método faz a exclusão de uma imagem de banner.
	 *
	 * @return boolean
	 * @param $id Integer ID do banner.
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	private function remove_image($id)
    {
    	$this->load->model('foto');
        $qry_foto = $this->foto->get_by_id($id)->row();
        $filename = './media/albuns/' . $qry_foto->album_id . '/' . $qry_foto->filename;
        if(file_exists($filename))
        {
            if(unlink($filename))
            {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}