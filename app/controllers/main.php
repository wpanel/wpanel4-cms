<?php

class main extends CI_Controller 
{

	var $template = 'default';

	var $data_header = array();
	var $data_content = array();
	var $data_footer = array();

	function __construct()
	{

		parent::__construct();
		$this->load->library('widgets');

		$this->data_header['wpn_meta'] = $this->wpanel->get_meta();
		$this->data_header['wpn_title'] = $this->wpanel->get_titulo();
		$this->data_header['wpn_assets'] = base_url('assets');
		$this->data_header['wpn_header_addthis'] = $this->_header_addthis();
		$this->data_header['wpn_header_facebook'] = $this->_header_facebook();
		$this->data_header['wpn_background'] = $this->_background();
		$this->data_header['wpn_logomarca'] = $this->_logomarca();

		$this->data_footer['wpn_copyright'] = $this->wpanel->get_config('copyright');
		$this->data_footer['wpn_google_analytics'] = $this->_google_analytics();

	}

	public function custom()
	{

        /*
         * Este método é chamado caso seja configurado o uso de um
         * página inicial personaizada no painel de configurações.
         * 
         * Para informações sobre como implementar um método personalizado
         * confira a documentação ou entre em contto com dev@elieldepaula.com.br
         */

        echo '<meta charset="UTF-8">';
        echo '<h1>Página inicial personalizada do wPanel.</h1>';
        echo '<p>Você pode alterar esta página pelo painel de controle indo em Configurações > Página inicial.</p>';

    }

	public function index()
	{

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

	public function posts($category_id = '')
    {

        // Carrega os models necessários.
        //----------------------------------------------------------
        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        // Envia os dados para a view de acordo com a categoria.
        //----------------------------------------------------------
        if ($category_id == '') {

            $this->data_content['posts'] = $this->post->get_by_field(array('page' => '0', 'status' => '1'), null, array('field' => 'created', 'order' => 'desc'));

        } else {

            $qry_category = $this->categoria->get_by_id($category_id)->row();
            $this->data_content['posts'] = $this->post->get_by_category($category_id, 'desc');
            $view = strtolower($qry_category->view);
            $this->data_content['titulo_view'] = $qry_category->title;
            $this->data_content['descricao_view'] = $qry_category->description;

        }

        // Seta as variáveis 'meta'.
        //----------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('posts/' . $category_id));
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title($titulo_view);

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
		$this->load->view($this->template.'/posts', $this->data_content);
		$this->load->view($this->template.'/footer', $this->data_footer);

    }

    public function post($link = '')
    {

        // Verifica se foi informado um link.
        //----------------------------------------------------------
        if ($link == '')
        	show_404();

        // Prepara e envia os dados para a view.
        //----------------------------------------------------------
        $this->load->model('post');
        $post = $this->post->get_by_field('link', $link)->row();
        $this->data_content['post'] = $post;

        // Verifica a existência e disponibilidade do post.
        //----------------------------------------------------------
        if (count($post) <= 0)
            show_404();
        
        if ($post->status == 0)
            show_error('Esta página foi suspensa temporariamente', 404);

        // Seta as variáveis 'meta'.
        //----------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('post/' . $link));
        $this->wpanel->set_meta_description($post->description);
        $this->wpanel->set_meta_keywords($post->tags);
        $this->wpanel->set_meta_title($post->title);
        if ($post->image) {
            $this->wpanel->set_meta_image(base_url('media/capas') . '/' . $post->image);
        } else {
            $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        }

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);

        // Seleciona a view específica de cada tipo de post.
        //----------------------------------------------------------
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

    public function events()
    {

        // Carrega os models necessários.
        //----------------------------------------------------------
        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        // Recupera a lista de eventos.
        //----------------------------------------------------------
        $query = $this->post->get_by_field(array('page' => '2', 'status' => '1'), null, array('field' => 'created', 'order' => 'desc'));

        // Seta as variáveis 'meta'.
        //----------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('events'));
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title($titulo_view);

        // Envia os dados para a view.
        //----------------------------------------------------------
        $this->data_content['posts'] = $query;

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/events', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    public function search()
    {

    	// Recebe os termos da busca.
        //----------------------------------------------------------
        $termos_busca = $this->input->post('search');

        // Carrega os models necessários.
        //----------------------------------------------------------
        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        // Envia os dados para a view.
        //----------------------------------------------------------
        $this->data_content['termos_busca'] = $termos_busca;
        $this->data_content['posts'] = $this->post->busca_posts($termos_busca);

        // Seta as variáveis 'meta'.
        //----------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('search'));
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title('Resultados da busca por ' . $termos_busca);

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/search', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    public function albuns()
    {
        
        // Carrega os models necessários.
        //----------------------------------------------------------
        $this->load->model('album');

        // Seta as variáveis 'meta'.
        //----------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('albuns'));
        $this->wpanel->set_meta_description('Álbuns de fotos');
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title('Álbuns de fotos');
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));

        // Envia os dados para a view.
        //----------------------------------------------------------
        $this->data_content['albuns'] = $this->album->get_list();

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/albuns', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    public function album($album_id)
    {

        // Carrega os models necessários.
        //----------------------------------------------------------
        $this->load->model('album');
        $this->load->model('foto');

        // Recupera os detalhes do álbum.
        //----------------------------------------------------------
        $album = $this->album->get_by_id($album_id)->row();

        // Seta as variáveis 'meta'.
        //----------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('album/' . $album_id));
        $this->wpanel->set_meta_description($album->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($album->titulo);
        $this->wpanel->set_meta_image(base_url('media/capas') . '/' . $album->capa);

        // Envia os dados para a view.
        //----------------------------------------------------------
        $this->data_content['album'] = $album;
        $this->data_content['fotos'] = $this->foto->get_by_field('album_id', $album_id, array('field' => 'created', 'order' => 'desc'));

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/album', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    public function foto($foto_id)
    {
        
        // Carrega os models necessários.
        //----------------------------------------------------------
        $this->load->model('album');
        $this->load->model('foto');

        // Recupera os detalhes da foto.
        //----------------------------------------------------------
        $foto = $this->foto->get_by_id($foto_id)->row();

        // Seta as variáveis 'meta'.
        //----------------------------------------------------------
        $this->wpanel->set_meta_url(site_url('foto/' . $foto_id));
        $this->wpanel->set_meta_description($foto->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($foto->descricao);
        $this->wpanel->set_meta_image(base_url('media/albuns/' . $foto->album_id) . '/' . $foto->filename);

        // Envia os dados para a view.
        //----------------------------------------------------------
        $this->data_content['album'] = $this->album->get_by_id($foto->album_id)->row();
        $this->data_content['foto'] = $foto;

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/foto', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    public function videos()
    {

    	// Recupera a lista de vídeos com a biblioteca Simplepie.
        //----------------------------------------------------------
        $this->load->library('Simplepie');
        $this->simplepie->set_feed_url($this->wpanel->get_config('youtube_rss'));
        $this->simplepie->set_cache_location(APPPATH . 'cache/rss');
        $this->simplepie->init();
        $this->simplepie->handle_content_type();

        // Envia os dados para a view.
        //----------------------------------------------------------
        $this->data_content['videos'] = $this->simplepie->get_items();

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/videos', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

    public function video($code)
    {

        // Envia os dados para a view.
        //----------------------------------------------------------
        $this->data_content['code'] = $code;

        // Exibe o template.
        //----------------------------------------------------------
        $this->load->view($this->template.'/header', $this->data_header);
        $this->load->view($this->template.'/video', $this->data_content);
        $this->load->view($this->template.'/footer', $this->data_footer);

    }

	public function contato()
	{

		$this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('captcha', 'Confirmação', 'required|captcha');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');

        if ($this->form_validation->run() == FALSE) {

        	$this->data_content['contact_content'] = $this->wpanel->get_config('texto_contato');
            $this->data_content['captcha'] = $this->form_validation->get_captcha();

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
                $this->session->set_flashdata('msg_contato', 'Sua mensagem foi enviada com sucesso!');
                redirect('contato');
            } else {
                $this->session->set_flashdata('msg_contato', 'Erro, sua mensagem não pode ser enviada, tente novamente mais tarde.');
                redirect('contato');
            }
		}
	}

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

    public function newsletter()
    {
        
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');

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
                print("<script>alert('Erro, seus dados não puderam ser salvos, tente novamente mais tarde.');</script>");
                redirect();
            }
        }
    }

	/* ----------------------- Métodos privados, não altere apartir daqui se não tiver certeza do que está fazendo! ----------------------- */

	private function _logomarca()
	{
		$image_properties = array(
        	'src' => base_url() . '/media/' . $this->wpanel->get_config('logomarca'),
        	'class' => 'img-responsive hidden-xs'
        );

        return img($image_properties);
	}

	private function _background()
	{
		$html  = "";
		$html .= "<style type=\"text/css\">
            body {
                background-image: url('" . base_url('media') . '/' . $this->wpanel->get_config('background') . "');
                background-color: " . $this->wpanel->get_config('bgcolor') . ";
            }
        </style>";  
		return $html;
	}

	private function _header_addthis()
	{
		$html  = "";
		$html .= "<script type=\"text/javascript\" src=\"//s7.addthis.com/js/300/addthis_widget.js#pubid=" . $this->wpanel->get_config('addthis_uid') . "\"></script>";  
		return $html;
	}

	private function _header_facebook()
	{
		$html = "";
		$html .= "<div id=\"fb-root\"></div>\n";
		$html .= "\t\t<script>
		             (function (d, s, id) {
		                 var js, fjs = d.getElementsByTagName(s)[0];
		                 if (d.getElementById(id))
		                     return;
		                 js = d.createElement(s);
		                 js.id = id;
		                 js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1472322323008859&version=v2.0\";
		                 fjs.parentNode.insertBefore(js, fjs);
		             }(document, 'script', 'facebook-jssdk'));
		        </script>";
		return $html;
	}

	private function _google_analytics()
	{
		return $this->wpanel->get_config('google_analytics');
	}

}	