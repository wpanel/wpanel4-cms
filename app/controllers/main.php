<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller
{

    // Define o template a ser usado.
	var $template = 'default';

    // Define as variáveis mais usadas no controller.
	var $data_header = array();
	var $data_content = array();
	var $data_footer = array();

    /**
     * ---------------------------------------------------------------------------------------------
     * Método construtor da classe.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
	function __construct()
	{

		parent::__construct();

        // Defini algumas variáveis usadas no header e footer do template.
        // -----------------------------------------------------------------------------------------
		$this->data_header['wpn_title']               = $this->wpanel->get_titulo();
		$this->data_header['wpn_assets']              = base_url('assets');
		$this->data_header['wpn_header_addthis']      = $this->wpanel->get_header_addthis();
		$this->data_header['wpn_header_facebook']     = $this->wpanel->get_header_facebook();
		$this->data_header['wpn_background']          = $this->wpanel->get_background();
		$this->data_header['wpn_logo']                = $this->wpanel->get_logo();

		$this->data_footer['wpn_copyright']           = $this->wpanel->get_config('copyright');
		$this->data_footer['wpn_google_analytics']    = $this->wpanel->get_google_analytics();

	}

    /**
     * ---------------------------------------------------------------------------------------------
     * Método 'custom', onde o desenvolvedor cria uma página inicial
     * personalizada.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
	public function custom()
	{

        /*
         * Este método é chamado caso seja configurado o uso de um
         * página inicial personaizada no painel de configurações.
         *
         * Para informações sobre como implementar um método personalizado
         * confira a documentação ou entre em contto com dev@elieldepaula.com.br>
         */

        echo '<meta charset="UTF-8">';
        echo '<h1>Página inicial personalizada do wPanel.</h1>';
        echo '<p>Você pode alterar esta página pelo painel de controle indo em Configurações >
                Página inicial.</p>';

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Método index() que faz o funcionamento da página inicial do site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
	public function index()
	{
        // Seleciona a página inicial de acordo com as configurações.
        //------------------------------------------------------------------------------------------
		switch ($this->wpanel->get_config('home_tipo')) {
            case 'page':
                $this->load->model('post');
                $query_post = $this->post->get_by_id($this->wpanel->get_config('home_id'))->row();
                $this->post($query_post->link);
                break;
            case 'category':
                $this->posts($this->wpanel->get_config('home_id'));
                break;
            default:
                return $this->custom();
                break;
        }
	}

    /**
     * ---------------------------------------------------------------------------------------------
     * O método posts() gera uma listagem das postagens disponíveis
     * para exibição no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $category_id Int ID da categoria para listagem.
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
	public function posts($category_id = '')
    {

        // Carrega os models necessários.
        //------------------------------------------------------------------------------------------
        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        // Envia os dados para a view de acordo com a categoria.
        //------------------------------------------------------------------------------------------
        if ($category_id == '') {

            $this->data_content['posts'] = $this->post->get_by_field(
                array('page' => '0',
                    'status' => '1'
                    ),
                null,
                array('field' => 'created', 'order' => 'desc')
            );

        } else {

            $qry_category = $this->categoria->get_by_id($category_id)->row();
            $this->data_content['posts'] = $this->post->get_by_category($category_id, 'desc');
            $view = strtolower($qry_category->view);
            $this->data_content['titulo_view'] = $qry_category->title;
            $this->data_content['descricao_view'] = $qry_category->description;

        }

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('posts/' . $category_id));
        $this->wpanel->set_meta_image(base_url('media') . '/' .
            $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title($titulo_view);
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
		$this->load->view($this->template.'/posts', $this->data_content);
		$this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método post() faz a exibição de uma postagem ou página que for
     * indicada pelo parametro $link.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $link String Link para exibição da postagem.
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function post($link = '')
    {

        // Verifica se foi informado um link.
        //------------------------------------------------------------------------------------------
        if ($link == '')
        	show_404();

        // Prepara e envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->load->model('post');
        $post = $this->post->get_by_field('link', $link)->row();
        $this->data_content['post'] = $post;

        // Verifica a existência e disponibilidade do post.
        //------------------------------------------------------------------------------------------
        if (count($post) <= 0)
            show_404();

        if ($post->status == 0)
            show_error('Esta página foi suspensa temporariamente', 404);

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('post/' . $link));
        $this->wpanel->set_meta_description($post->description);
        $this->wpanel->set_meta_keywords($post->tags);
        $this->wpanel->set_meta_title($post->title);
        if ($post->image) {
            $this->wpanel->set_meta_image(base_url('media/capas') . '/' . $post->image);
        } else {
            $this->wpanel->set_meta_image(base_url('media') . '/' .
                $this->wpanel->get_config('logomarca'));
        }
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);

        // Seleciona a view específica de cada tipo de post.
        //------------------------------------------------------------------------------------------
        switch ($post->page) {
        	case '1':
        		$this->load->view($this->template.'/page', $this->data_content);
        		break;
        	case '2':
        		$this->load->view($this->template.'/event', $this->data_content);
        		break;
        	default:
        		$this->load->view($this->template.'/post', $this->data_content);
        		break;
        }
		$this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método events() faz uma listagem dos eventos disponíveis para
     * exibição no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function events()
    {

        // Carrega os models necessários.
        //------------------------------------------------------------------------------------------
        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        // Recupera a lista de eventos.
        //------------------------------------------------------------------------------------------
        $query = $this->post->get_by_field(
            array('page' => '2', 'status' => '1'),
            null,
            array('field' => 'created', 'order' => 'desc')
        );

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('events'));
        $this->wpanel->set_meta_image(base_url('media') . '/' .
            $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title($titulo_view);
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->data_content['posts'] = $query;

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/events', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método search() realiza uma busca por termos indicados no formulário
     * no título, descrição e conteúdo das postagens independente do seu tipo.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function search()
    {

    	// Recebe os termos da busca.
        //------------------------------------------------------------------------------------------
        $termos_busca = $this->input->post('search');

        // Carrega os models necessários.
        //------------------------------------------------------------------------------------------
        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        // Envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->data_content['termos_busca'] = $termos_busca;
        $this->data_content['posts'] = $this->post->busca_posts($termos_busca);

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('search'));
        $this->wpanel->set_meta_image(base_url('media') . '/' .
            $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title('Resultados da busca por ' . $termos_busca);
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/search', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método albuns() faz uma listagem de albuns de foto disponíveis
     * para exibição no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function albuns()
    {

        // Carrega os models necessários.
        //------------------------------------------------------------------------------------------
        $this->load->model('album');

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('albuns'));
        $this->wpanel->set_meta_description('Álbuns de fotos');
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title('Álbuns de fotos');
        $this->wpanel->set_meta_image(base_url('media') . '/' .
            $this->wpanel->get_config('logomarca'));
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->data_content['albuns'] = $this->album->get_list();

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/albuns', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método album() faz a exibição das fotos de um determinado álbum
     * indicado pelo parametro $album_id
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $album_id Int ID do álbum para exibição.
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function album($album_id)
    {

        // Carrega os models necessários.
        //------------------------------------------------------------------------------------------
        $this->load->model('album');
        $this->load->model('foto');

        // Recupera os detalhes do álbum.
        //------------------------------------------------------------------------------------------
        $album = $this->album->get_by_id($album_id)->row();

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('album/' . $album_id));
        $this->wpanel->set_meta_description($album->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($album->titulo);
        $this->wpanel->set_meta_image(base_url('media/capas') . '/' . $album->capa);
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->data_content['album'] = $album;
        $this->data_content['fotos'] = $this->foto->get_by_field('album_id', $album_id,
            array('field' => 'created', 'order' => 'desc'));

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/album', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O metodo foto() faz a exibição de uma foto de algum ámbum, indicada
     * pelo parâmmetro $foto_id
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $foto_id Int ID da foto para exibição.
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function foto($foto_id)
    {

        // Carrega os models necessários.
        //------------------------------------------------------------------------------------------
        $this->load->model('album');
        $this->load->model('foto');

        // Recupera os detalhes da foto.
        //------------------------------------------------------------------------------------------
        $foto = $this->foto->get_by_id($foto_id)->row();

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('foto/' . $foto_id));
        $this->wpanel->set_meta_description($foto->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($foto->descricao);
        $this->wpanel->set_meta_image(base_url('media/albuns/' . $foto->album_id) . '/' .
            $foto->filename);
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->data_content['album'] = $this->album->get_by_id($foto->album_id)->row();
        $this->data_content['foto'] = $foto;

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/foto', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método videos() faz a exibição da lista de vídeos de um canal do
     * Youtube(®) pelo método de RSS.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function videos()
    {

        // Recupera a lista de vídeos.
        //------------------------------------------------------------------------------------------
        $this->load->model('video');
        $query = $this->video->get_by_field(
            'status', 
            '1', 
            array('field'=>'created','order'=>'desc')
        )->result();

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('videos'));
        $this->wpanel->set_meta_description('Lista de vídeos');
        $this->wpanel->set_meta_keywords(' videos, filmes');
        $this->wpanel->set_meta_title('Vídeos');
        $this->wpanel->set_meta_image(base_url('media') . '/' .
            $this->wpanel->get_config('logomarca'));
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->data_content['query'] = $query;

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/videos', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método video() faz a exibição do vídeo indicado pelo parametro $code.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $code string Código do vídeo no youtube.
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function video($code)
    {

        // Recupera os dados do vídeo.
        //------------------------------------------------------------------------------------------
        $query = $this->video->get_by_field('link', $code)->row();

        // Envia os dados para a view.
        //------------------------------------------------------------------------------------------
        $this->load->model('video');
        $this->data_content['video'] = $query;

        // Seta as variáveis 'meta'.
        //------------------------------------------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('video/'.$code));
        $this->wpanel->set_meta_description($query->titulo);
        $this->wpanel->set_meta_keywords(' videos, filmes');
        $this->wpanel->set_meta_title($query->titulo);
        $this->wpanel->set_meta_image(base_url('media') . '/' .
            $this->wpanel->get_config('logomarca'));
        $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

        // Exibe o template.
        //------------------------------------------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/video', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método contato() faz o funcionamento da página de contato do site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
	public function contato()
	{

		$this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('captcha', 'Confirmação', 'required|captcha');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">',
            '</span></p>');

        if ($this->form_validation->run() == FALSE) {

            // Seta as variáveis 'meta'.
            //--------------------------------------------------------------------------------------
            $this->wpanel->set_meta_url(site_url('contato'));
            $this->wpanel->set_meta_description('Formulário de contato');
            $this->wpanel->set_meta_keywords(' Contato, Fale Conosco');
            $this->wpanel->set_meta_title('Contato');
            $this->wpanel->set_meta_image(base_url('media') . '/' .
                $this->wpanel->get_config('logomarca'));
            $this->data_header['wpn_meta'] = $this->wpanel->get_meta();

            // Recupera a imagem de captcha.
            //--------------------------------------------------------------------------------------
        	$this->data_content['contact_content'] = $this->wpanel->get_config('texto_contato');
            $this->data_content['captcha'] = $this->form_validation->get_captcha();

            // Exibe o template.
            //--------------------------------------------------------------------------------------
			$this->load->view($this->template.'/header', $this->data_header);
			$this->load->view($this->template.'/contact', $this->data_content);
			$this->load->view($this->template.'/footer', $this->data_footer);

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
                $this->session->set_flashdata('msg_contato',
                    'Sua mensagem foi enviada com sucesso!');
                redirect('contato');
            } else {
                $this->session->set_flashdata('msg_contato',
                    'Erro, sua mensagem não pode ser enviada, tente novamente mais tarde.');
                redirect('contato');
            }
		}
	}

    /**
     * ---------------------------------------------------------------------------------------------
     * O método rss() gera a página padrão XML para os leitores de RSS
     * com as postagens disponíveis no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
	public function rss()
    {

        $this->load->model('post');
        $query = $this->post->get_list()->result();

        $rss = '<?xml version="1.0" encoding="utf-8"?>';
        $rss .= '<rss version="2.0">';
        $rss .= '<channel>';
        $rss .= '<title>'.$this->wpanel->get_titulo().'</title>';
        $rss .= '<description>'.$this->wpanel->get_config('site_desc').'</description>';
        $rss .= '<link>'.site_url().'</link>';
        $rss .= '<language>en</language>';

        foreach($query as $row) {
            	$rss .= '<item>';
                $rss .= "<title>$row->title</title>";
                $rss .= "<description>$row->description</description>";
                $rss .= "<lastBuildDate>$row->created</lastBuildDate>";
                $rss .= "<link>".site_url('post/'.$row->link)."</link>";
                $rss .= '</item>';
        }

        $rss .= '</channel></rss>';

        echo $rss;

    }

    /**
     * ---------------------------------------------------------------------------------------------
     * O método newsletter() faz o cadastro de um email para o coletor
     * de contatos do WPanel.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function newsletter()
    {

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">',
            '</span></p>');

        if ($this->form_validation->run() == FALSE) {

        	if(print("<script>alert('Preencha os dados no final da página.');</script>"))
        		redirect();

        } else {
            $this->load->model('newsletter');
            $dados_save = array(
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'created' => date('Y-m-d H:i:s')
            );
            if ($this->newsletter->save($dados_save)) {
                print("<script>alert('Seus dados foram salvos com sucesso, obrigado!');</script>");
                redirect('');
            } else {
                print("<script>alert('Erro, seus dados não puderam ser salvos, tente novamente mais
                    tarde.');</script>");
                redirect();
            }
        }
    }
}
