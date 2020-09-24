<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.com/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Classe Main
 *
 * Contém os métodos básicos do site.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Main extends MY_Controller
{
    /**
     * @var Wpanel
     */
    public $wpanel;
    /**
     * @var Post
     */
    public $post;
    /**
     * @var Categorytegory
     */
    public $category;
    /**
     * @var Gallery
     */
    public $gallery;
    /**
     * @var Picture
     */
    public $picture;
    /**
     * @var Video
     */
    public $video;
    /**
     * @var Newsletter
     */
    public $newsletter;

    /**
     * Construtor da classe.
     *
     * @return void
     */
    function __construct()
    {

        /**
         * Informa o número de colunas do layout 'Mosaico'.
         */
        $this->wpn_cols_mosaic = 3;

        /**
         * Informa a view padrão para as postagens: 'list' ou 'mosaic'.
         */
        $this->wpn_posts_view = 'mosaic';

        /**
         * Informa os models.
         */
        $this->model_file = ['post', 'category', 'gallery', 'picture', 'video', 'newsletter'];

        parent::__construct();

        /**
         * Define o template.
         */
        $this->template('default');

    }

    /**
     * Você pode usar este método para criar uma página inicial personalizada e
     * então selecionar como padrão no painel de controle.
     */
    public function custom()
    {
        $this->wpanel->set_meta_title('Início');
        $this->view('main/custom')->render();
    }

    /**
     * Este método retorna a página inicial configurada no painel de controle.
     */
    public function index()
    {
        $this->set_var('show_slide', true);
        switch (wpn_config('home_tipo')) {
            case 'page':
                $this->post(wpn_config('home_id'), true);
                break;
            case 'category':
                $this->posts(wpn_config('home_id'));
                break;
            default:
                $this->custom();
                break;
        }
    }

    /**
     * Retorna uma lista de posts que pode ser por categoria. A exibição pode
     * ser em mosaico ou em lista.
     *
     * @param $category_id Int Id da categoria.
     */
    public function posts($category_id = null)
    {
        if ($category_id == null) {
            $this->set_var('posts', $this->post
                ->order_by('created_on', 'desc')
                ->select('id, title, link, image, content, created_on')
                ->find_many_by(array('page' => '0', 'status' => '1')));
            $view_title = 'Todas as postagens';
        } else {
            $qry_category = $this->category
                ->select('id, title, description, view')
                ->find($category_id);
            $this->set_var('posts', $this->post->get_by_category($category_id, 'desc')->result());
            $this->set_var('view_title', $qry_category->title);
            $this->set_var('view_description', $qry_category->description);
            $view_title = $qry_category->title;
            $this->wpn_posts_view = strtolower($qry_category->view);
        }
        if ($this->wpn_posts_view == 'mosaic') {
            $this->set_var('max_cols', $this->wpn_cols_mosaic);
        }
        $this->wpanel->set_meta_title($view_title);
        $this->view('main/posts_' . $this->wpn_posts_view)->render();
    }

    /**
     * Este método exibe uma postagem usando um link ou Id como referência.
     *
     * @param $var mixed Link ou ID da postagem.
     * @param $use_id boolean Indica que $var é um Id.
     */
    public function post($var = null, $use_id = false)
    {
        if ($var === null) {
            show_404();
        }
        if ($use_id) {
            $query = $this->post
                ->select('id, title, content, link, tags, image, page, description, status, created_on')
                ->find($var);
        } else {
            $query = $this->post
                ->select('id, title, content, link, tags, image, page, description, status, created_on')
                ->find_by('link', $var);
        }
        $this->set_var('post', $query);
        if (@count($query) <= 0) {
            show_404();
        }
        if ($query->status == 0) {
            show_error('Esta página foi suspensa temporariamente', 404);
        }
        $this->wpanel->set_meta_description($query->description);
        $this->wpanel->set_meta_keywords($query->tags);
        $this->wpanel->set_meta_title($query->title);
        if (file_exists('./media/capas/' . $query->image)) {
            $this->wpanel->set_meta_image(base_url('media/capas/' . $query->image));
        }
        switch ($query->page) {
            case '1':
                $this->view('main/page')->render();
                break;
            default:
                $this->view('main/post')->render();
                break;
        }
    }

    /**
     * Busca simples no cadastro de postagens.
     */
    public function search()
    {
        $search_terms = $this->input->post('search', TRUE);
        $this->set_var('search_terms', $search_terms);
        $this->set_var('results', $this->post->busca_posts($search_terms)->result());
        $this->wpanel->set_meta_title('Resultados da busca por ' . $search_terms);
        $this->render();
    }

    /**
     * Lista as galerias de fotos.
     */
    public function galleries()
    {
        $limit = 10;
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->gallery->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('galleries/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $query = $this->gallery
            ->limit($limit, $offset)
            ->select('id, titulo, capa, created_on')
            ->order_by('created_on', 'desc')
            ->find_many_by('status', 1);
        $this->wpanel->set_meta_description('Álbuns de fotos');
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title('Álbuns de fotos');
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('albuns', $query);
        $this->set_var('max_cols', $this->wpn_cols_mosaic);
        $this->render();
    }

    /**
     * Lista as fotos de uma galeria indicada pelo  Id.
     *
     * @param $album_id Int Id da galeria.
     */
    public function gallery($album_id = null, $fake_link = '')
    {
        if ($album_id === null) {
            show_404();
        }
        $limit = 12;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->picture->count_by(array('album_id' => $album_id, 'status' => 1, 'deleted' => '0'));
        $config = array();
        $config['base_url'] = site_url('gallery/' . $album_id . '/' . $fake_link . '/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $query_album = $this->gallery
            ->select('id, titulo, capa, descricao, tags, status, created_on')
            ->find($album_id);
        if (!isset($query_album)) {
            show_404();
        }
        if (!$query_album->status) {
            show_error('Este álbum foi suspenso temporariamente', 404);
        }
        $query_pictures = $this->picture
            ->select('id, filename, descricao')
            ->limit($limit, $offset)
            ->find_many_by(array('album_id' => $album_id, 'status' => 1));
        $this->wpanel->set_meta_description($query_album->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($query_album->titulo);
        if (file_exists('./media/capas/' . $query_album->capa)) {
            $this->wpanel->set_meta_image(base_url('media/capas' . '/' . $query_album->capa));
        }
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('album', $query_album);
        $this->set_var('pictures', $query_pictures);
        $this->set_var('max_cols', $this->wpn_cols_mosaic);
        $this->render();
    }

    /**
     * Exibe a foto indicada pelo Id. Este método é indicado quando você
     * não quer usar o plugin lightbox.
     *
     * @param $picture_id Int Id da imagem.
     */
    public function picture($picture_id = null)
    {
        if ($picture_id === null) {
            show_404();
        }
        $query_picture = $this->picture
            ->select('id, album_id, filename, descricao, status')
            ->find($picture_id);
        $query_album = $this->gallery
            ->select('id, titulo, descricao, created_on')
            ->find($query_picture->album_id);
        if (!isset($query_picture)) {
            show_404();
        }
        if (!$query_picture->status) {
            show_error('Esta foto foi suspensa temporariamente', 404);
        }
        $this->wpanel->set_meta_description($query_picture->descricao);
        $this->wpanel->set_meta_keywords('album, fotos');
        $this->wpanel->set_meta_title($query_picture->descricao);
        if (file_exists('./media/albuns/' . $query_picture->album_id . '/' . $query_picture->filename)) {
            $this->wpanel->set_meta_image(base_url('media/albuns/' . $query_picture->album_id . '/' . $query_picture->filename));
        }
        $this->set_var('album', $query_album);
        $this->set_var('picture', $query_picture);
        $this->render();
    }

    /**
     * Lista os vídeos do Youtube que foram cadastrados no painel de controle.
     */
    public function videos()
    {
        $limit = 10;
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->video->count_by(array('status' => 1, 'deleted' => '0'));
        $config = array();
        $config['base_url'] = site_url('videos/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $query_videos = $this->video
            ->limit($limit, $offset)
            ->select('id, titulo, link')
            ->order_by('created_on', 'desc')
            ->find_many_by('status', 1);
        $this->wpanel->set_meta_description('Lista de vídeos');
        $this->wpanel->set_meta_keywords('videos, filmes');
        $this->wpanel->set_meta_title('Vídeos');
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('videos', $query_videos);
        $this->set_var('max_cols', $this->wpn_cols_mosaic);
        $this->render();
    }

    /**
     * Exibe um vídeo indicado pelo Código do vídeo.
     *
     * @param $code string Código do vídeo no youtube.
     */
    public function video($code = null)
    {
        if ($code === null) {
            show_404();
        }
        $query_video = $this->video
            ->select('titulo, descricao, link, tags, status')
            ->find_by(array('link' => $code, 'status' => 1));
        if (!isset($query_video)) {
            show_404();
        }
        if (!$query_video->status) {
            show_error('Este vídeo foi suspenso temporariamente', 404);
        }
        $this->set_var('video', $query_video);
        $this->wpanel->set_meta_description($query_video->titulo);
        $this->wpanel->set_meta_keywords('videos, filmes');
        $this->wpanel->set_meta_title($query_video->titulo);
        $this->wpanel->set_meta_image('http://img.youtube.com/vi/' . $code . '/0.jpg');
        $this->render();
    }

    /**
     * Formulário de contato com captcha.
     */
    public function contact()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('captcha', 'Confirmação', 'required|captcha');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_description('Formulário de contato');
            $this->wpanel->set_meta_keywords(' Contato, Fale Conosco');
            $this->wpanel->set_meta_title('Contato');
            $this->set_var('contact_content', wpn_config('texto_contato'));
            $this->set_var('captcha', $this->form_validation->get_captcha());
            $this->render();
        } else {
            $nome = $this->input->post('nome');
            $email = $this->input->post('email');
            $telefone = $this->input->post('telefone');
            $mensagem = $this->input->post('mensagem');
            $msg = "";
            $msg .= "Mensagem enviada pelo site.\n\n";
            $msg .= "Nome: $nome\n";
            $msg .= "Email: $email\n";
            $msg .= "Telefone: $telefone\n";
            $msg .= "IP: " . $this->input->server('REMOTE_ADDR', true) . "\n\n";
            $msg .= "Mensagem\n";
            $msg .= "------------------------------------------------------\n\n";
            $msg .= "$mensagem";
            $msg .= "\n\n";
            $msg .= "Enviado pelo WPanel CMS\n";
            $mail_data = array(
                'html' => FALSE,
                'from_name' => $nome,
                'from_email' => $email,
                'to' => wpn_config('site_contato'),
                'subject' => 'Formulário de contato - ' . wpn_config('site_titulo'),
                'message' => $msg,
            );
            $data = array(
                'nome' => $this->input->post('nome', true),
                'email' => $this->input->post('email', true)
            );
            $this->newsletter->create_lead($data);
            if (!$this->wpanel->send_email($mail_data)) {
                $this->set_message('Sua mensagem não pode ser enviada.', 'danger', 'contact');
            }
            $this->set_message('Sua mensagem foi enviada com sucesso!', 'success', 'contact');
        }
    }

    /**
     * Gera um RSS com a lista de postagens para os "Feed Readers".
     *
     * @deprecated Este método será removido na proxima release.
     */
    public function rss()
    {
        $query = $this->post->order_by('created_on', 'desc')->find_all();
        $available_languages = config_item('available_languages');
        $locale = $available_languages[wpn_config('language')]['locale'];
        $rss = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $rss .= "<rss version=\"2.0\">\n";
        $rss .= "\t<channel>\n";
        $rss .= "\t\t<title>" . wpn_config('site_titulo') . "</title>\n";
        $rss .= "\t\t<description>" . wpn_config('site_desc') . "</description>\n";
        $rss .= "\t\t<link>" . site_url() . "</link>\n";
        $rss .= "\t\t<language>" . $locale . "</language>\n";
        foreach ($query as $row) {
            $rss .= "\t\t<item>\n";
            $rss .= "\t\t\t<title>" . $row->title . "</title>\n";
            $rss .= "\t\t\t<description>" . $row->description . "</description>\n";
            $rss .= "\t\t\t<lastBuildDate>" . $row->created_on . "</lastBuildDate>\n";
            $rss .= "\t\t\t<link>" . site_url('post/' . $row->link) . "</link>\n";
            $rss .= "\t\t</item>\n";
        }
        $rss .= "\t</channel>\n</rss>\n";
        echo $rss;
    }

    /**
     * Formulário de captação de leads (emails newsletters).
     */
    public function newsletter()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_description('Newsletter');
            $this->wpanel->set_meta_keywords('Cadastro, Newsletter');
            $this->wpanel->set_meta_title('Newsletter');
            $this->render();
        } else {
            $data = array(
                'nome' => $this->input->post('nome', true),
                'email' => $this->input->post('email', true),
                'ipaddress' => $this->input->server('REMOTE_ADDR', true)
            );
            if (!$this->newsletter->insert($data)) {
                $this->set_message('Não foi possível salvar os seus dados, verifique e tente novamente.', 'danger', 'newsletter');
            }
            $this->set_message('Seus dados foram salvos com sucesso!', 'success', 'newsletter');
        }
    }
}

