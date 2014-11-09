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

	function __construct() 
	{
		// Códigos e chamadas executados ao iniciar a classe.
	}

	/**
	 * Este método exibe a página inicial do site.
	 *
	 * @return void
	 * @author Eliel de Paula <elieldepaula@gmail.com>
	 **/
	public function index() 
	{
		/**
		 * Este bloco verifica se deve exibir uma página específica ou
		 * se deve listar uma categoria específica na página inicial.
		 */
		if ($this->wpanel->get_config('home_tipo') == 'page') 
		{
			$this->load->model('post');
			$query_post = $this->post->get_by_id($this->wpanel->get_config('home_id'))->row();
			$this->post($query_post->link);
		} 
		elseif ($this->wpanel->get_config('home_tipo') == 'category') 
		{
			$this->posts($this->wpanel->get_config('home_id'));
		}
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
		$titulo_view = '';
		$tipos_views = config_item('posts_views');
		$view = 'lista';
		$qry_post = null;
		$qry_category = null;

		$this->load->model('post');
		$this->load->model('categoria');
		$this->load->model('post_categoria');

		if($category_id == '')
		{
			$qry_post = $this->post->get_by_field(array('page'=>'0', 'status'=>'1'), null, array('field'=>'created', 'order'=>'desc'));
		} else {
			$qry_category = $this->categoria->get_by_id($category_id)->row();
			$qry_post = $this->post->get_by_category($category_id, 'desc');
			$view = strtolower($qry_category->view);
			$titulo_view = 'Postagens de '.$qry_category->title;
		}

		// Seta as variáveis 'meta'
		$this->wpanel->set_meta_url(site_url('posts/' . $category_id));
		$this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
		$this->wpanel->set_meta_title($titulo_view);

		$content_vars['titulo_view'] = $titulo_view;
		$content_vars['posts'] = $qry_post;

		$layout_vars['content'] = $this->load->view($tipos_views[$view], $content_vars, TRUE);

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

        // Verifica se foi informado um link.
		if ($link == '')
		{
			show_404();
		}

		$layout_vars = array();
		$content_vars = array();
		$this->load->model('post');

		$post = $this->post->get_by_field('link', $link)->row();

        // Verifica a existência e disponibilidade do post.
		if (count($post) <= 0) 
		{
			show_404();
		}
		if ($post->status == 0) 
		{
			show_error('Esta página foi suspensa temporariamente', 404);
		}

        // Seta as variáveis 'meta'
		$this->wpanel->set_meta_url(site_url('post/' . $link));
		$this->wpanel->set_meta_description($post->description);
		$this->wpanel->set_meta_keywords($post->tags);
		$this->wpanel->set_meta_title($post->title);

		if ($post->image) 
		{
			$this->wpanel->set_meta_image(base_url('media/capas') . '/' . $post->image);
		} 
		else 
		{
			$this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
		}

		$content_vars['post'] = $post;

		// Variáveis obrigatórias para o layout
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
		$content_vars['page_title'] = ' - resultado da busca "'.$termos_busca.'"';
		$layout_vars['content'] = $this->load->view('main_posts', $content_vars, TRUE);

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

		if ($this->form_validation->run() == FALSE) 
		{

			$content_vars['conf'] = $this->wpanel->get_config();
			$content_vars['captcha'] = $this->form_validation->get_captcha();

			// Variáveis obrigatórias para o layout
			$content_vars['page_title'] = ' - fale conosco';
			$layout_vars['content'] = $this->load->view('main_contato', $content_vars, TRUE);

			$this->load->view($this->layout, $layout_vars);

		} 
		else 
		{

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

			if ($this->email->send()) 
			{
				$this->session->set_flashdata('msg_contato', 'Sua mensagem foi enviada com sucesso!');
				redirect('contato');
			} 
			else 
			{
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
		if ($this->form_validation->run() == FALSE) 
		{
			// Variáveis obrigatórias para o layout
			$content_vars['page_title'] = ' - cadastro de newsletter.';
			$layout_vars['content'] = $this->load->view('main_newsletter', $content_vars, TRUE);
			$this->load->view($this->layout, $layout_vars);
		} 
		else 
		{
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
			} 
			else 
			{
				$this->session->set_flashdata('msg_newsletter', 'Erro, seus dados não puderam ser salvos, tente novamente mais tarde.');
				redirect('newsletter');
			}
		}
	}
}