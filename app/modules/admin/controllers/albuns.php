<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class albuns extends MX_Controller {
	
	function __construct()
	{
		$this->auth->protect('admin');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{
		$this->load->model('album');
		$this->load->library('table');

		$layout_vars = array();
		$content_vars = array();

		// Template da tabela
		$this->table->set_template(array('table_open'  => '<table id="grid" class="table table-striped">')); 
		$this->table->set_heading('#', 'Capa', 'Título', 'Data', 'Status', 'Ações');
		$query = $this->album->get_list();

		foreach($query->result() as $row)
		{

			$capa_properties = array(
            	'src' => base_url() . '/media/capas/' . $row->capa,
            	'class' => 'img-responsive',
            	'width' => '120',
            	'alt' => $row->titulo
            );
            $capa = img($capa_properties);

			$this->table->add_row(
				$row->id, 
				$capa, 
				anchor('admin/fotos/index/'.$row->id, glyphicon('picture') . $row->titulo),
				mdate('%d/%m/%Y - %H:%i', strtotime($row->created)),
				status_post($row->status), 
				div(array('class'=>'btn-group btn-group-sm')).
				anchor('admin/fotos/index/'.$row->id, glyphicon('picture'), array('class' => 'btn btn-default')).
				anchor('admin/albuns/edit/'.$row->id, glyphicon('edit'), array('class' => 'btn btn-default')).
				'<button class="btn btn-default" onClick="return confirmar(\''.site_url('admin/albuns/delete/' . $row->id).'\');">'.glyphicon('trash').'</button>' .
				div(null,true)
			);
		}

		$content_vars['listagem'] = $this->table->generate();
		$this->wpanel->load_view('albuns/index', $content_vars);
	}	

	public function add()
	{
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('titulo', 'Título', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->wpanel->load_view('albuns/add', $content_vars);
		} else {

			$this->load->model('album');

			$dados_save = array();
			$dados_save['user_id'] = $this->auth->get_userid();
			$dados_save['titulo'] = $this->input->post('titulo');
			$dados_save['descricao'] = $this->input->post('descricao');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['created'] = date('Y-m-d H:i:s');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['capa'] = $this->upload();

			$new_post = $this->album->save($dados_save);
			mkdir('./media/albuns/'.$new_post);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Album salvo com sucesso.');
				redirect('admin/albuns');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o album.');
				redirect('admin/albuns');
			}
		}
	}	

	public function edit($id = null)
	{
		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('titulo', 'Título', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Album inexistente.');
				redirect('admin/albuns');
			}

			$this->load->model('album');
			$content_vars['id'] = $id;
			$content_vars['row'] = $this->album->get_by_id($id)->row();
			$this->wpanel->load_view('albuns/edit', $content_vars);

		} else {

			$this->load->model('album');

			$dados_save = array();
			$dados_save['titulo'] = $this->input->post('titulo');
			$dados_save['descricao'] = $this->input->post('descricao');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			
			if($this->input->post('alterar_imagem')=='1')
			{
				$this->remove_image($id);
				$dados_save['capa'] = $this->upload();
			}

			$new_post = $this->album->update($id, $dados_save);

			if($new_post)
			{
				$this->session->set_flashdata('msg_sistema', 'Album salvo com sucesso.');
				redirect('admin/albuns');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o álbum.');
				redirect('admin/albuns');
			}
		}
	}	

	public function delete($id = null)
	{

		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Album inexistente.');
			redirect('admin/albuns');
		}

		$this->load->model('album');

		$this->remove_image($id);

		if($this->album->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Album excluído com sucesso.');
			redirect('admin/albuns');
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir o album.');
			redirect('admin/albuns');
		}
	}

	private function upload()
	{

		$config['upload_path'] = './media/capas/';
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

	private function remove_image($id)
    {
    	$this->load->model('album');
        $album = $this->album->get_by_id($id)->row();
        $filename = './media/capas/' . $album->capa;
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