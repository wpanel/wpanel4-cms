<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Esta classe reúne os métodos para o funcionamento de um
 * site básico do wPanel com Páginas, Blog, Contato etc.
 *
 * @package wPanel
 * @author Eliel de Paula <elieldepaula@gmail.com>
 * @since 28/10/2014
 **/
class main extends MX_Controller {

	/**
	 * Esta variável recebe o nome do layout principal do site
	 * onde as views serão inseridas.
	 *
	 * @var string
	 **/
	public $layout = 'layout';

	function __construct() {
		$this->load->model('banner');
	}

	/**
	 * Este método exibe a página inicial do site.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function index() {
		/**
		 * Este bloco verifica se deve exibir uma página específica ou
		 * se deve listar uma categoria específica na página inicial.
		 */
		if ($this->wpanel->get_config('home_tipo') == 'page') {
			$this->post_to_home($this->wpanel->get_config('home_id'));
		} elseif ($this->wpanel->get_config('home_tipo') == 'category') {
			$this->posts_to_home($this->wpanel->get_config('home_id'));
		}
	}

	/**
	 * Este método exibe uma postagem com base na variável $id e foi criado
	 * especialmente para ser usado na página inicial do site.
	 *
	 * @return void
	 * @param $link String Link da postagem.
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function post_to_home($id = '') {

		if ($id == '') {
			show_404();
		}

		$layout_vars = array();
		$content_vars = array();
		$this->load->model('post');

		$post = $this->post->get_by_id($id)->row();

		if (count($post) <= 0) {
			show_404();
		}

		if ($post->status == 0) {
			show_error('Esta página foi suspensa temporariamente', 404);
		}

		$content_vars['post'] = $post;

		// Variáveis obrigatórias para o layout
		$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
		$layout_vars['content'] = $this->load->view('main_post_to_home', $content_vars, TRUE);

		$this->load->view($this->layout, $layout_vars);
	}

	/**
	 * Este método lista as postagens de uma categoria indicada
	 * pela variável $category_id, foi desenvolvido para ser
	 * usado na página inicial para não exibir o título da
	 * categoria na tela inicial do site.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @param $category_id Int ID da categoria a ser listada.
	 **/
	public function posts_to_home($category_id = '')
	{
		$layout_vars = array();
		$content_vars = array();
		$this->load->model('post');
		$this->load->model('categoria');
		$this->load->model('post_categoria');

		// Variáveis da página inicial
		if ($category_id == '') {
			$content_vars['posts'] = $this->post->get_by_field(
				array('page'=>'0', 'status'=>'1'), 
				null, 
				array('field'=>'created', 'order'=>'desc')
			);
		} else {
			$content_vars['titulo_view'] = '';
			$content_vars['posts'] = $this->post->get_by_category($category_id, 'desc');
		}

		// Variáveis obrigatórias para o layout
		$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
		$layout_vars['content'] = $this->load->view('main_posts', $content_vars, TRUE);

		$this->load->view($this->layout, $layout_vars);
	}

	/**
	 * Este método lista as postagens de uma categoria indicada
	 * pela variável $category_id
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 * @param $category_id Int ID da categoria a ser listada.
	 **/
	public function posts($category_id = '')
	{
		$layout_vars = array();
		$content_vars = array();
		$this->load->model('post');
		$this->load->model('categoria');
		$this->load->model('post_categoria');

		$qry_category = $this->categoria->get_by_id($category_id)->row();

		// Seleciona o tipo de visualização pela categoria
		if ($category_id != '' and $qry_category->view == 'Mosaico') {
			$view = 'main_posts_mosaico';
		} else {
			$view = 'main_posts';
		}

		// Variáveis da view interna
		if ($category_id == '') {
			$content_vars['posts'] = $this->post->get_by_field(
				array('page'=>'0', 'status'=>'1'), 
				null, 
				array('field'=>'created', 'order'=>'desc')
			);
		} else {
			$content_vars['titulo_view'] = 'Posts de "'.$qry_category->title.'"';
			$content_vars['posts'] = $this->post->get_by_category($category_id, 'desc');
		}

		$content_vars['categoria'] = $qry_category;

		// Variáveis obrigatórias para o layout
		$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
		$layout_vars['content'] = $this->load->view($view, $content_vars, TRUE);

		$this->load->view($this->layout, $layout_vars);
	}

	/**
	 * Este método exibe uma postagem.
	 *
	 * @return void
	 * @param $link String Link da postagem.
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function post($link = '') {

		if ($link == '') {
			show_404();
		}

		$layout_vars = array();
		$content_vars = array();
		$this->load->model('post');

		$post = $this->post->get_by_field('link', $link)->row();

		if (count($post) <= 0) {
			show_404();
		}

		if ($post->status == 0) {
			show_error('Esta página foi suspensa temporariamente', 404);
		}

		$content_vars['post'] = $post;

		// Variáveis obrigatórias para o layout
		$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
		$layout_vars['content'] = $this->load->view('main_post', $content_vars, TRUE);

		$this->load->view($this->layout, $layout_vars);
	}

	/**
	 * Este método faz a exibição do resultado de uma pesquisa.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function search()
	{
		$termos_busca = $this->input->post('search');

		$layout_vars = array();
		$content_vars = array();
		$this->load->model('post');
		$this->load->model('categoria');
		$this->load->model('post_categoria');
		// Variáveis da página interna
		$content_vars['titulo_view'] = 'Resultados da busca por "'.$termos_busca.'"';
		$content_vars['posts'] = $this->post->busca_posts($termos_busca);
		// Variáveis obrigatórias para o layout
		$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
		$layout_vars['content'] = $this->load->view('main_posts', $content_vars, TRUE);

		$this->load->view($this->layout, $layout_vars);
	}

	/**
	 * Este método faz a listagem de vídeos integrada ao Youtube.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function videos() {
		$layout_vars = array();
		$content_vars = array();
		$this->load->library('Simplepie');

		$this->simplepie->set_feed_url($this->wpanel->get_config()->youtube_rss);
		$this->simplepie->set_cache_location(APPPATH . 'cache/rss');
		$this->simplepie->init();
		$this->simplepie->handle_content_type();

		$content_vars['lista_videos'] = $this->simplepie->get_items();

		// Variáveis obrigatórias para o layout
		$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
		$layout_vars['content'] = $this->load->view('main_videos', $content_vars, TRUE);

		$this->load->view($this->layout, $layout_vars);
	}

	/**
	 * Este método faz a exibição de um vídeo de acordo com o $code informado.
	 *
	 * @return void
	 * @param $code String Código do vídeo do Youtube.
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function video($code) {
		$layout_vars = array();
		$content_vars = array();

		$content_vars['code'] = $code;

		// Variáveis obrigatórias para o layout
		$layout_vars['menu_categorias'] = $this->wpanel->menu_categorias();
		$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
		$layout_vars['content'] = $this->load->view('main_video', $content_vars, TRUE);

		$this->load->view($this->layout, $layout_vars);
	}

	/**
	 * Este método faz a exibição e funcionamento da página de contato do site.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function contato()
	{

		$layout_vars = array();
		$content_vars = array();

		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('captcha', 'Confirmação', 'required|captcha');

		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');

		if ($this->form_validation->run() == FALSE) {

			$content_vars['conf'] = $this->wpanel->get_config();
			$content_vars['captcha'] = $this->form_validation->get_captcha();

			// Variáveis obrigatórias para o layout
			$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
			$layout_vars['content'] = $this->load->view('main_contato', $content_vars, TRUE);

			$this->load->view($this->layout, $layout_vars);

		} else {

			$nome = $this->input->post('nome');
			$email = $this->input->post('email');
			$telefone = $this->input->post('telefone');
			$mensagem = $this->input->post('mensagem');

			$msg = "";
			$msg .= "Mensagem enviada pelo site.\n\n";
			$msg .= "Nome: $nome\n";
			$msg .= "Email: $email\n";
			$msg .= "Telefone: $telefone\n\n";
			$msg .= "Mensagem\n";
			$msg .= "------------------------------------------------------\n\n";
			$msg .= "$mensagem";
			$msg .= "\n\n";
			$msg .= "wPanel 11\n";

			$this->load->library('email');
			// Verifica se usa SMTP ou não
			if ($this->wpanel->get_config('usa_smtp') == 1) {
				$conf_email = array();
				$conf_email['protocol'] = 'smtp';
				$conf_email['smtp_host'] = $this->wpanel->get_config('smtp_servidor');
				$conf_email['smtp_port'] = $this->wpanel->get_config('smtp_porta');
				$conf_email['smtp_user'] = $this->wpanel->get_config('smtp_usuario');
				$conf_email['smtp_pass'] = $this->wpanel->get_config('smtp_senha');
				$this->email->initialize($conf_email);
			}
			// Envia o email
			$this->email->from($email, $nome);
			$this->email->to($this->wpanel->get_config('site_contato'));
			$this->email->subject('[Mensagem do site]');
			$this->email->message($msg);

			if ($this->email->send()) {
				$this->session->set_flashdata('msg_contato', 'Sua mensagem foi enviada com sucesso!');
				redirect('contato');
			} else {
				$this->session->set_flashdata('msg_contato', 'Erro, sua mensagem não pode ser enviada, tente novamente mais tarde.');
				redirect('contato');
			}
		}
	}

	/**
	 * Este método faz o cadastro dos dados para a newsletter.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function newsletter()
	{
		$layout_vars = array();
		$content_vars = array();
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
		if ($this->form_validation->run() == FALSE) {
			// Variáveis obrigatórias para o layout
			$layout_vars['banner_slide'] = $this->banner->get_banners('slide');
			$layout_vars['content'] = $this->load->view('main_newsletter', $content_vars, TRUE);
			$this->load->view($this->layout, $layout_vars);
		} else {
			$this->load->model('newsletter');
			$dados_save = array(
				'nome' => $this->input->post('nome'),
				'email' => $this->input->post('email'),
				'created' => date('Y-m-d H:i:s')
			);
			if($this->newsletter->save($dados_save))
			{
				$this->session->set_flashdata('msg_newsletter', 'Seus dados foram salvos com sucesso!');
				redirect('');
			} else {
				$this->session->set_flashdata('msg_newsletter', 'Erro, seus dados não puderam ser salvos, tente novamente mais tarde.');
				redirect('newsletter');
			}
		}
	}
}