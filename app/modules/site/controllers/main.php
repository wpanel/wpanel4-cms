<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Esta classe reúne os métodos para o funcionamento de um
 * site básico do wPanel com Páginas, Blog, Contato etc.
 *
 * @package wPanel
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 28/10/2014
 * */
class main extends MX_Controller
{

    /**
     * Esta variável recebe o nome do layout principal do site
     * onde as views serão inseridas.
     *
     * @var string
     * */
    public $layout = 'layout';

    function __construct()
    {
        // Códigos e chamadas executados ao iniciar a classe.
    }

    public function custom() {
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

    /**
     * Este método exibe a página inicial do site.
     *
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function index()
    {
        /**
         * Este bloco verifica se deve exibir uma página específica ou
         * se deve listar uma categoria específica na página inicial.
         */
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
     * Este método lista as postagens de uma categoria indicada
     * pela variável $category_id
     *
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $category_id Int ID da categoria a ser listada.
     * */
    public function posts($category_id = '')
    {

        $layout_vars = array();
        $content_vars = array();
        $titulo_view = '';
        $posts_views = config_item('posts_views');
        $view = 'lista';
        $qry_post = null;
        $qry_category = null;

        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        if ($category_id == '') {
            $qry_post = $this->post->get_by_field(array('page' => '0', 'status' => '1'), null, array('field' => 'created', 'order' => 'desc'));
        } else {
            $qry_category = $this->categoria->get_by_id($category_id)->row();
            $qry_post = $this->post->get_by_category($category_id, 'desc');
            $view = strtolower($qry_category->view);
            $titulo_view = 'Postagens de ' . $qry_category->title;
            $descricao_view = $qry_category->description;
        }

        // Seta as variáveis 'meta'
        $this->wpanel->set_meta_url(site_url('posts/' . $category_id));
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title($titulo_view);

        $content_vars['titulo_view'] = $titulo_view;
        $content_vars['descricao_view'] = $descricao_view;
        $content_vars['posts'] = $qry_post;

        $layout_vars['content'] = $this->load->view($posts_views[$view], $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método exibe uma postagem.
     *
     * @return void
     * @param $link String Link da postagem.
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function post($link = '')
    {

        // Verifica se foi informado um link.
        if ($link == '') {
            show_404();
        }

        $layout_vars = array();
        $content_vars = array();
        $this->load->model('post');

        $post = $this->post->get_by_field('link', $link)->row();

        // Verifica a existência e disponibilidade do post.
        if (count($post) <= 0) {
            show_404();
        }
        if ($post->status == 0) {
            show_error('Esta página foi suspensa temporariamente', 404);
        }

        // Seta as variáveis 'meta'
        $this->wpanel->set_meta_url(site_url('post/' . $link));
        $this->wpanel->set_meta_description($post->description);
        $this->wpanel->set_meta_keywords($post->tags);
        $this->wpanel->set_meta_title($post->title);

        if ($post->image) {
            $this->wpanel->set_meta_image(base_url('media/capas') . '/' . $post->image);
        } else {
            $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        }

        $content_vars['post'] = $post;

        // Variáveis obrigatórias para o layout
        $layout_vars['content'] = $this->load->view('main_post', $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método lista as postagens de eventos.
     *
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function eventos()
    {

        $layout_vars = array();
        $content_vars = array();
        $posts_views = config_item('posts_views');
        $view = 'lista';

        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        $qry_post = $this->post->get_by_field(array('page' => '2', 'status' => '1'), null, array('field' => 'created', 'order' => 'desc'));
        $titulo_view = 'Eventos';

        // Seta as variáveis 'meta'
        $this->wpanel->set_meta_url(site_url('events'));
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title($titulo_view);

        $content_vars['titulo_view'] = $titulo_view;
        $content_vars['posts'] = $qry_post;

        $layout_vars['content'] = $this->load->view($posts_views[$view], $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método exibe uma lista com todos os álbuns de foto.
     *
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function albuns()
    {
        $layout_vars = array();
        $content_vars = array();
        $this->load->model('album');

        // Seta as variáveis 'meta'
        $this->wpanel->set_meta_url(site_url('albuns'));
        $this->wpanel->set_meta_description('Álbuns de fotos');
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title('Álbuns de fotos');
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));

        // Variáveis obrigatórias para o layout
        $content_vars['albuns'] = $this->album->get_list();
        $layout_vars['content'] = $this->load->view('main_albuns', $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método exibe um álbum de foto de acordo com o ID.
     *
     * @return void
     * @param $album_id Int ID do álbum de foto.
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function album($album_id)
    {
        $layout_vars = array();
        $content_vars = array();
        $this->load->model('album');
        $this->load->model('foto');

        $album = $this->album->get_by_id($album_id)->row();

        // Seta as variáveis 'meta'
        $this->wpanel->set_meta_url(site_url('album/' . $album_id));
        $this->wpanel->set_meta_description($album->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($album->titulo);
        $this->wpanel->set_meta_image(base_url('media/capas') . '/' . $album->capa);

        // Variáveis obrigatórias para o layout
        $content_vars['album'] = $album;
        $content_vars['fotos'] = $this->foto->get_by_field('album_id', $album_id, array('field' => 'created', 'order' => 'desc'));

        $layout_vars['content'] = $this->load->view('main_album', $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método exibe uma foto pronta para compartilhamento
     * nas redes sociais e para comentários.
     *
     * @return void
     * @param $foto_id Int ID da foto.
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function foto($foto_id)
    {
        $layout_vars = array();
        $content_vars = array();
        $this->load->model('album');
        $this->load->model('foto');

        $foto = $this->foto->get_by_id($foto_id)->row();

        // Seta as variáveis 'meta'
        $this->wpanel->set_meta_url(site_url('foto/' . $foto_id));
        $this->wpanel->set_meta_description($foto->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($foto->descricao);
        $this->wpanel->set_meta_image(base_url('media/albuns/' . $foto->album_id) . '/' . $foto->filename);

        // Variáveis obrigatórias para o layout
        $content_vars['album'] = $this->album->get_by_id($foto->album_id)->row();
        $content_vars['foto'] = $foto;

        $layout_vars['content'] = $this->load->view('main_foto', $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método faz a listagem de vídeos integrada ao Youtube.
     *
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function videos()
    {
        $layout_vars = array();
        $content_vars = array();
        $this->load->library('Simplepie');

        $this->simplepie->set_feed_url($this->wpanel->get_config('youtube_rss'));
        $this->simplepie->set_cache_location(APPPATH . 'cache/rss');
        $this->simplepie->init();
        $this->simplepie->handle_content_type();

        $content_vars['lista_videos'] = $this->simplepie->get_items();

        // Variáveis obrigatórias para o layout
        $layout_vars['content'] = $this->load->view('main_videos', $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método faz a exibição de um vídeo de acordo com o $code informado.
     *
     * @return void
     * @param $code String Código do vídeo do Youtube.
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function video($code)
    {
        $layout_vars = array();
        $content_vars = array();

        $content_vars['code'] = $code;

        // Variáveis obrigatórias para o layout
        $layout_vars['content'] = $this->load->view('main_video', $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método faz a exibição do resultado de uma pesquisa.
     *
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function search()
    {

        $termos_busca = $this->input->post('search');

        $layout_vars = array();
        $content_vars = array();

        $this->load->model('post');
        $this->load->model('categoria');
        $this->load->model('post_categoria');

        // Variáveis da página interna
        $content_vars['titulo_view'] = 'Resultados da busca por "' . $termos_busca . '"';
        $content_vars['posts'] = $this->post->busca_posts($termos_busca);

        // Seta as variáveis 'meta'
        $this->wpanel->set_meta_url(site_url('search'));
        $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
        $this->wpanel->set_meta_title('Resultados da busca por ' . $termos_busca);

        // Variáveis obrigatórias para o layout
        $content_vars['page_title'] = ' - resultado da busca "' . $termos_busca . '"';
        $layout_vars['content'] = $this->load->view('main_posts', $content_vars, TRUE);

        $this->load->view($this->layout, $layout_vars);
    }

    /**
     * Este método faz a exibição e funcionamento da página de contato do site.
     *
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
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

            // Seta as variáveis 'meta'
            $this->wpanel->set_meta_url(site_url('contato'));
            $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
            $this->wpanel->set_meta_title('Contato');

            // Variáveis obrigatórias para o layout
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
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * */
    public function newsletter()
    {
        $layout_vars = array();
        $content_vars = array();

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');

        if ($this->form_validation->run() == FALSE) {
            // Seta as variáveis 'meta'
            $this->wpanel->set_meta_url(site_url('newsletter'));
            $this->wpanel->set_meta_image(base_url('media') . '/' . $this->wpanel->get_config('logomarca'));
            $this->wpanel->set_meta_title('Cadastro de newsletters');
            // Variáveis obrigatórias para o layout
            $content_vars['page_title'] = ' - cadastro de newsletter.';
            $layout_vars['content'] = $this->load->view('main_newsletter', $content_vars, TRUE);
            $this->load->view($this->layout, $layout_vars);
        } else {
            $this->load->model('newsletter');
            $dados_save = array(
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'created' => date('Y-m-d H:i:s')
            );
            if ($this->newsletter->save($dados_save)) {
                $this->session->set_flashdata('msg_newsletter', 'Seus dados foram salvos com sucesso!');
                redirect('');
            } else {
                $this->session->set_flashdata('msg_newsletter', 'Erro, seus dados não puderam ser salvos, tente novamente mais tarde.');
                redirect('newsletter');
            }
        }
    }
    
    /**
     * Este método faz o funcionamento básico do RSS do wpanel.
     * 
     * @return void
     * @author Eliel de Paula <dev@elieldepaula.com.br>
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

}
