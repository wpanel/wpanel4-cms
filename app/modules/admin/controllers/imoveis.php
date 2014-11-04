<?php 

/*
|--------------------------------------------------------------------------
| Este é o controller de imóveis, usado principalmente
| no painel de controle do site.
|
| @author Eliel de Paula <elieldepaula@gmail.com>
| @since 20/10/2014
|--------------------------------------------------------------------------
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imoveis extends MX_Controller {

	function __construct()
	{
		$this->auth->protect('admin');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{ 
		$this->load->model('imovel');
		$layout_vars = array();
		$content_vars = array();
		$content_vars['imoveis'] = $this->imovel->list_all()->result();
		$layout_vars['content'] = $this->load->view('imoveis_index', $content_vars, TRUE);
		$this->load->view('layout', $layout_vars);
	}

	public function add()
	{
		$this->form_validation->set_rules('titulo', 'Título do anúncio', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{

			$layout_vars = array();
			$content_vars = array();

			$layout_vars['content'] = $this->load->view('imoveis_add', $content_vars, TRUE);

			$this->load->view('layout', $layout_vars);

		} else {

			$this->load->model('imovel');

			$dados_save = array(
				'user_id' => $this->auth->get_userid(),
				'titulo' => $this->input->post('titulo'),
				'slug' => url_title(convert_accented_characters($this->input->post('titulo'))),
				'descricao' => $this->input->post('descricao'),
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
				'tipo_imovel' => $this->input->post('tipo_imovel'),
				'tipo_negocio' => $this->input->post('tipo_negocio'),
				'status' => $this->input->post('status'),
				'valor' => $this->input->post('valor'),
				'comodos' => $this->input->post('comodos'),
				'suites' => $this->input->post('suites'),
				'garagem' => $this->input->post('garagem'),
				'area_construida' => $this->input->post('area_construida'),
				'area_terreno' => $this->input->post('area_terreno'),
				'endereco' => $this->input->post('endereco'),
				'numero' => $this->input->post('numero'),
				'complemento' => $this->input->post('complemento'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
				'uf' => $this->input->post('uf'),
				'cep' => $this->input->post('cep')
				);

			$novo_imovel = $this->imovel->save($dados_save);

			if($novo_imovel)
			{
				$this->session->set_flashdata('msg_sistema', 'Imóvel salvo com sucesso.');
				redirect('admin/imoveis/edit/'.$novo_imovel);
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o imóvel.');
				redirect('admin/imoveis');
			}

		}

	}

	public function edit($id = null)
	{
		$this->load->model('imovel');

		// Verifica se altera a senha
		if($this->input->post('alterar_senha') == '1'){
			$this->form_validation->set_rules('password', 'Senha', 'required|md5');
		}
		
		$this->form_validation->set_rules('titulo', 'Título do anúncio', 'required');

		if ($this->form_validation->run() == FALSE)
		{

			if($id == null){
				$this->session->set_flashdata('msg_sistema', 'Imóvel inexistente.');
				redirect('admin/imoveis');
			}

			$layout_vars = array();
			$content_vars = array();

			$content_vars['adm_fotos'] = $this->load->view('imoveis_fotos', NULL, TRUE);
			$content_vars['row'] = $this->imovel->get_by_id($id)->row();
			$layout_vars['content'] = $this->load->view('imoveis_edit', $content_vars, TRUE);

			$this->load->view('layout', $layout_vars);

		} else {

			$dados_save = array();
			$dados_save['titulo'] = $this->input->post('titulo');
			$dados_save['slug'] = url_title(convert_accented_characters($this->input->post('titulo')));
			$dados_save['descricao'] = $this->input->post('descricao');
			$dados_save['updated'] = date('Y-m-d H:i:s');
			$dados_save['tipo_imovel'] = $this->input->post('tipo_imovel');
			$dados_save['tipo_negocio'] = $this->input->post('tipo_negocio');
			$dados_save['status'] = $this->input->post('status');
			$dados_save['valor'] = $this->input->post('valor');
			$dados_save['comodos'] = $this->input->post('comodos');
			$dados_save['suites'] = $this->input->post('suites');
			$dados_save['garagem'] = $this->input->post('garagem');
			$dados_save['area_construida'] = $this->input->post('area_construida');
			$dados_save['area_terreno'] = $this->input->post('area_terreno');
			$dados_save['endereco'] = $this->input->post('endereco');
			$dados_save['numero'] = $this->input->post('numero');
			$dados_save['complemento'] = $this->input->post('complemento');
			$dados_save['bairro'] = $this->input->post('bairro');
			$dados_save['cidade'] = $this->input->post('cidade');
			$dados_save['uf'] = $this->input->post('uf');
			$dados_save['cep'] = $this->input->post('cep');

			if($this->imovel->update($id, $dados_save))
			{
				$this->session->set_flashdata('msg_sistema', 'Imóvel salvo com sucesso.');
				redirect('admin/imoveis');
			} else {
				$this->session->set_flashdata('msg_sistema', 'Erro ao salvar o imóvel.');
				redirect('admin/imoveis');
			}

		}

	}

	public function delete($id = null)
	{
		if($id == null){
			$this->session->set_flashdata('msg_sistema', 'Imóvel inexistente.');
			redirect('admin/imoveis');
		}

		$this->load->model('imovel');

		if($this->imovel->delete($id)){
			$this->session->set_flashdata('msg_sistema', 'Imóvel excluído com sucesso.');
			redirect('admin/imoveis');
		} else {
			$this->session->set_flashdata('msg_sistema', 'Erro ao excluir o imóvel.');
			redirect('admin/imoveis');
		}
	}

	public function fotos($imovel_id = null)
	{
		$this->load->model('fotos_imoveis');
		
		$dados_view = array();
		$dados_view['id'] = $imovel_id;
		$dados_view['llista_fotos'] = $this->fotos_imoveis->get_by_field('imovel_id', $imovel_id)->result();
		
		$this->load->view('imoveis_fotos', $dados_view);
	}

	public function upload_foto()
	{

		$imovel_id = $this->input->post('id');

		$config['upload_path'] = './media/fotos_imoveis/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '1000';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['remove_spaces'] = TRUE;
		$config['file_name'] = $imovel_id . '_' . md5(date('YmdHis'));

		$this->load->library('upload', $config);

		if ($this->upload->do_upload())
		{
			$upload_data = $this->upload->data();
			
			$this->load->model('fotos_imoveis');

			$dados_save = array();
			$dados_save['imovel_id'] = $imovel_id;
			$dados_save['file'] = $upload_data['file_name'];

			if($this->fotos_imoveis->save($dados_save)){
				redirect('admin/imoveis/fotos/'.$imovel_id);
			} else {
				echo '<b>Erro:</b> Carregou a imagem mas não cadastrou no banco de dados.';
			}

		} else {
			echo '<b>Erro:</b> ' . $this->upload->display_errors();
		}
	}

	public function delete_foto($id)
	{
		$this->load->model('fotos_imoveis');
		$foto = $this->fotos_imoveis->get_by_id($id)->row();

		if (file_exists('./media/fotos_imoveis/' . $foto->file))
		{

			$this->fotos_imoveis->delete($id);

			if (unlink('./media/fotos_imoveis/' . $foto->file))
			{
				redirect('admin/imoveis/fotos/'.$foto->imovel_id);
			} else {
				echo '<b>Erro:</b> Não foi possível apagar a foto.';
			}
		} else {
			echo '<b>Erro:</b> Esta foto não existe.';
		}
	}
}