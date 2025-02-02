<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.com/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

class Main extends MY_Controller
{
    /** @var Wpanel */
    public $wpanel;
    /** @var Post */
    public $post;
    /** @var Categorytegory */
    public $category;
    /** @var Gallery */
    public $gallery;
    /** @var Picture */
    public $picture;
    /** @var Video */
    public $video;
    /** @var Newsletter */
    public $newsletter;

    /**
     * Class constructor.
     */
    function __construct()
    {

        /**
         * Set the number of columns of the layout 'Mosaic'.
         */
        $this->wpn_cols_mosaic = 3;

        /**
         * Set a default view for posts: 'list' or 'mosaic'.
         */
        $this->wpn_posts_view = 'mosaic';

        /**
         * Load the models.
         */
        $this->model_file = ['post', 'category', 'gallery', 'picture', 'video', 'newsletter'];

        /**
         * Load the language file.
         */
        $this->language_file = 'controller_main_lang';

        parent::__construct();

        /**
         * Set the template.
         */
        $this->template('default');

    }

    /**
     * You can use this method to create a custom homepage and then select it as
     * default in the control panel.
     *
     * @return void
     */
    public function custom()
    {
        $this->wpanel->set_meta_title('Início');
        $this->view('main/custom')->render();
    }

    /**
     * This method returns the homepage as configured in the control panel.
     *
     * @return void
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
     * This method returns a post list, can be by category. The list can be in
     * mosaic or list view.
     *
     * @param $category_id int Category id
     * @return void
     */
    public function posts($category_id = null)
    {
        if ($category_id == null) {
            $this->set_var('posts', $this->post
                ->order_by('created_on', 'desc')
                ->select('id, title, link, image, content, created_on')
                ->find_many_by(array('page' => '0', 'status' => '1')));
            $view_title = wpn_lang('all_posts_title');
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
     * This method returns a single post using a link or id as reference.
     *
     * @param $var mixed Link or ID of the post
     * @param $use_id boolean Indicates that $var is an ID
     * @return void
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
            show_error(wpn_lang('suspended_page_message'), 404);
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
     * Simple search on posts.
     *
     * @return void
     */
    public function search()
    {
        $search_terms = $this->input->post('search', TRUE);
        $this->set_var('search_terms', $search_terms);
        $this->set_var('results', $this->post->busca_posts($search_terms)->result());
        $this->wpanel->set_meta_title(wpn_lang('search_results_title') . $search_terms);
        $this->render();
    }

    /**
     * Pictures gallery list.
     *
     * @return void
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
        $this->wpanel->set_meta_description(wpn_lang('picture_gallery_title'));
        $this->wpanel->set_meta_keywords(wpn_lang('picture_gallery_keywords'));
        $this->wpanel->set_meta_title(wpn_lang('picture_gallery_title'));
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('albuns', $query);
        $this->set_var('max_cols', $this->wpn_cols_mosaic);
        $this->render();
    }

    /**
     * List of pictures from an album by id.
     *
     * @param $album_id
     * @param $fake_link
     * @return void
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
            show_error(wpn_lang('suspended_album_message'), 404);
        }
        $query_pictures = $this->picture
            ->select('id, filename, descricao')
            ->limit($limit, $offset)
            ->find_many_by(array('album_id' => $album_id, 'status' => 1));
        $this->wpanel->set_meta_description($query_album->descricao);
        $this->wpanel->set_meta_keywords(wpn_lang('picture_gallery_keywords'));
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
     * Shows a picture by id. This method is intended when you don't want to use the lightbox plugin.
     *
     * @param $picture_id int Id of the picture
     * @return void
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
            show_error(wpn_lang('suspended_picture_message'), 404);
        }
        $this->wpanel->set_meta_description($query_picture->descricao);
        $this->wpanel->set_meta_keywords(wpn_lang('picture_gallery_keywords'));
        $this->wpanel->set_meta_title($query_picture->descricao);
        if (file_exists('./media/albuns/' . $query_picture->album_id . '/' . $query_picture->filename)) {
            $this->wpanel->set_meta_image(base_url('media/albuns/' . $query_picture->album_id . '/' . $query_picture->filename));
        }
        $this->set_var('album', $query_album);
        $this->set_var('picture', $query_picture);
        $this->render();
    }

    /**
     * List of videos.
     *
     * @return void
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
        $this->wpanel->set_meta_description(wpn_lang('video_gallery_title'));
        $this->wpanel->set_meta_keywords(wpn_lang('video_gallery_keywords'));
        $this->wpanel->set_meta_title(wpn_lang('video_gallery_title'));
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('videos', $query_videos);
        $this->set_var('max_cols', $this->wpn_cols_mosaic);
        $this->render();
    }

    /**
     * Shows a video by youtube code.
     *
     * @param $code
     * @return void
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
            show_error(wpn_lang('suspended_video_message'), 404);
        }
        $this->set_var('video', $query_video);
        $this->wpanel->set_meta_description($query_video->titulo);
        $this->wpanel->set_meta_keywords(wpn_lang('video_gallery_keywords'));
        $this->wpanel->set_meta_title($query_video->titulo);
        $this->wpanel->set_meta_image('http://img.youtube.com/vi/' . $code . '/0.jpg');
        $this->render();
    }

    /**
     * Contact form with captcha.
     *
     * @return void
     */
    public function contact()
    {
        $this->form_validation->set_rules('nome', wpn_lang('input_name'), 'required');
        $this->form_validation->set_rules('email', wpn_lang('input_email'), 'required|valid_email');
        $this->form_validation->set_rules('captcha', wpn_lang('input_captcha'), 'required|captcha');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_description(wpn_lang('contact_page_title'));
            $this->wpanel->set_meta_keywords(wpn_lang('contact_page_keywords'));
            $this->wpanel->set_meta_title(wpn_lang('contact_page_title'));
            $this->set_var('contact_content', wpn_config('texto_contato'));
            $this->set_var('captcha', $this->form_validation->get_captcha());
            $this->render();
        } else {
            $nome = $this->input->post('nome');
            $email = $this->input->post('email');
            $telefone = $this->input->post('telefone');
            $mensagem = $this->input->post('mensagem');
            //TODO: #31 Create HTML template to sending messages. (https://github.com/wpanel/wpanel4-cms/issues/31)
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
                $this->set_message(wpn_lang('contact_send_error'), 'danger', 'contact');
            }
            $this->set_message(wpn_lang('contact_send_success'), 'success', 'contact');
        }
    }

    /**
     * Generate a RSS feed.
     *
     * @return void
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
     * This form is used to capture leads (emails newsletters).
     *
     * @return void
     */
    public function newsletter()
    {
        $this->form_validation->set_rules('nome', wpn_lang('input_name'), 'required');
        $this->form_validation->set_rules('email', wpn_lang('input_email'), 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        if (!$this->form_validation->run()) {
            $this->wpanel->set_meta_description(wpn_lang('newsletter_page_title'));
            $this->wpanel->set_meta_keywords(wpn_lang('newsletter_page_keywords'));
            $this->wpanel->set_meta_title(wpn_lang('newsletter_page_title'));
            $this->render();
        } else {
            $data = array(
                'nome' => $this->input->post('nome', true),
                'email' => $this->input->post('email', true),
                'ipaddress' => $this->input->server('REMOTE_ADDR', true)
            );
            if (!$this->newsletter->insert($data)) {
                $this->set_message(wpn_lang('newsletter_send_error'), 'danger', 'newsletter');
            }
            $this->set_message(wpn_lang('newsletter_send_success'), 'success', 'newsletter');
        }
    }
}

