<?php 

/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Controller Class
 *
 * This class maintain the methods of the basic website. It was thought that
 * you add more resources to your project creating new Controller Classes
 * extending MY_Controller Class to get the common features.
 *
 * @package     WpanelCms
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        https://wpanelcms.com.br
 * @version     0.0.1
 */
class Main extends MY_Controller 
{

    /**
     * Class constructor.
     *
     * @return void
     */
    function __construct() 
    {
        /*
        * Here are some options provided by the MY_Controller class, you
        * can adjust as you need to your project.
        */
        // Enable the CodeIgniter Profile.
        // $this->wpn_profiler = FALSE;
        // Chose the template folder.
        // $this->wpn_template = 'default';
        // Setup the 'col' number of the mosaic views.
        // $this->wpn_cols_mosaic = 3;
        parent::__construct();
    }

    /**
     * You can use this method to create 'custom' home page to your site and
     * then select the 'custom' page in the admin configuration panel.
     *
     * @return void
     */
    public function custom() 
    {
        echo '<meta charset="UTF-8">';
        echo '<title>Custom Home Page</title>';
        echo '<h1>This is a custom home-page of Wpanel CMS.</h1>';
        echo '<p>You can change this in the control panel following: 
            Configurations > Home Page.</p>';
    }

    /**
     * The method index() select the configured home page of the site.
     *
     * @return void
     */
    public function index() 
    {
        switch ($this->wpanel->get_config('home_tipo')) {
            case 'page':
                $this->post($this->wpanel->get_config('home_id'), true);
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
     * The method posts() retuns a list of posts, it can be categoryzed and
     * can be a list or mosaic view.
     *
     * @param $category_id Int Category ID.
     * @return void
     */
    public function posts($category_id = null) 
    {
        $view_title = '';
        $view_description = '';
        $this->load->model('post');
        $this->load->model('categoria');
        // Check if is a categoryzed list.
        if ($category_id == null) {
            $this->data_content['posts'] = $this->post->get_by_field(
                ['page' => '0', 'status' => '1'], 
                null, 
                ['field' => 'created', 'order' => 'desc'], 
                null, 
                'id, title, description, content, link, image, created'
            )->result();
            $view_title = 'Todas as postagens';
        } else {
            $qry_category = $this->categoria->get_by_id($category_id, null, null, 'title, description, view')->row();
            $this->data_content['posts'] = $this->post->get_by_category($category_id, 'desc')->result();
            $this->data_content['view_title'] = $qry_category->title;
            $this->data_content['view_description'] = $qry_category->description;
            $view_title = $qry_category->title;
            $this->wpn_posts_view = strtolower($qry_category->view);
        }
        // Send $max_cols if the view is mosaic type.
        if($this->wpn_posts_view == 'mosaic')
            $this->data_content['max_cols'] = $this->wpn_cols_mosaic;
        $this->wpanel->set_meta_title($view_title);
        $this->render('posts_' . $this->wpn_posts_view);
    }

    /**
     * The method post() shows a post by link or by ID if $use_id = True.
     *
     * @param $link mixed Link or ID field of the post.
     * @param $use_id boolean Indicates if $link is a ID.
     * @return void
     */
    public function post($link = '', $use_id = false) 
    {
        if ($link == '')
            show_404();
        $this->load->model('post');
        if($use_id)
            $query = $this->post->get_by_id(
                $link, 
                null, 
                null, 
                'id, title, description, content, link, image, tags, created, page, status'
            )->row();
        else 
            $query = $this->post->get_by_field(
                'link', 
                $link, 
                null, 
                null, 
                'id, title, description, content, link, image, tags, created, page, status'
            )->row();
        $this->data_content['post'] = $query;
        if (count($query) <= 0)
            show_404();
        if ($query->status == 0)
            show_error('Esta página foi suspensa temporariamente', 404);
        $this->wpanel->set_meta_description($query->description);
        $this->wpanel->set_meta_keywords($query->tags);
        $this->wpanel->set_meta_title($query->title);
        if(file_exists('./media/capas/'.$query->image))
            $this->wpanel->set_meta_image(base_url('media/capas/'.$query->image));
        // Select the spacific type of view according to type of post.
        switch ($query->page) {
            case '1':
                $this->render('page');
                break;
            case '2':
                $this->render('event');
                break;
            default:
                $this->render('post');
                break;
        }
    }

    /**
     * The method events() shows a list of posts typed as 'event'.
     *
     * @return void
     */
    public function events() 
    {
        $view_title = 'Eventos';
        $this->load->model('post');
        $query = $this->post->get_by_field(
                ['page' => '2', 'status' => '1'], 
                null, 
                ['field' => 'created', 'order' => 'desc']
        )->result();
        $this->wpanel->set_meta_title($view_title);
        $this->wpanel->set_meta_description('Lista de eventos');
        $this->wpanel->set_meta_keywords(' eventos, agenda');
        $this->data_content['events'] = $query;
        $this->render('events');
    }

    /**
     * The method search() make a simple search function into the Posts.
     * 
     * @todo Melhorar a view de resultados usando um estilo de tabela.
     * @return void
     */
    public function search() 
    {
        $search_terms = $this->input->post('search');
        $this->load->model('post');
        $this->data_content['search_terms'] = $search_terms;
        $this->data_content['results'] = $this->post->busca_posts($search_terms)->result();
        $this->wpanel->set_meta_title('Resultados da busca por ' . $search_terms);
        $this->render('search');
    }

    /**
     * The method albuns() list all the available galeries of the site.
     *
     * @return void
     */
    public function albuns() 
    {
        $this->load->model('album');
        $query = $this->album->get_by_field(
            'status', 1, 
            ['field'=>'created', 'order'=>'desc'], 
            'titulo, capa, created'
        )->result();
        $this->wpanel->set_meta_description('Álbuns de fotos');
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title('Álbuns de fotos');
        $this->data_content['albuns'] = $query;
        $this->data_content['max_cols'] = $this->wpn_cols_mosaic;
        $this->render('albuns');
    }

    /**
     * The method album() shows a list of pictures of a galery selected by $album_id.
     *
     * @param $album_id Int ID of the galery.
     * @return void
     */
    public function album($album_id = null) 
    {
        if ($album_id == null)
            show_404();
        $this->load->model('album');
        $this->load->model('foto');
        $query_album = $this->album->get_by_id(
            $album_id, 
            null, 
            null, 
            'id, titulo, descricao, capa, created, status'
        )->row();
        if (count($query_album) <= 0)
            show_404();
        if ($query_album->status == 0)
            show_error('Este álbum foi suspenso temporariamente', 404);
        $query_pictures = $this->foto->get_by_field(
            ['album_id'=>$album_id, 'status'=>1], 
            null, 
            ['field' => 'created', 'order' => 'desc'],
            null,
            'id, filename, descricao'
        )->result();
        $this->wpanel->set_meta_description($query_album->descricao);
        $this->wpanel->set_meta_keywords(' album, fotos');
        $this->wpanel->set_meta_title($query_album->titulo);
        if(file_exists('./media/capas/'.$query_album->capa))
            $this->wpanel->set_meta_image(base_url('media/capas'.'/'.$query_album->capa));
        $this->data_content['album']    = $query_album;
        $this->data_content['pictures'] = $query_pictures;
        $this->data_content['max_cols'] = $this->wpn_cols_mosaic;
        $this->render('album');
    }

    /**
     * The method foto() shows the picture selected by $picture_id, it only works
     * if you are not using the lightbox plugin.
     *
     * @param $picture_id Int Id of the picture.
     * @return void
     */
    public function foto($picture_id = null)
    {
        if ($picture_id == null)
            show_404();
        $this->load->model('album');
        $this->load->model('foto');
        $query_picture = $this->foto->get_by_id(
            $picture_id, null, null, 
            'id, album_id, filename, descricao, status'
        )->row();
        $query_album = $this->album->get_by_id(
            $query_picture->album_id, 
            null, 
            null, 
            'id, titulo, descricao, capa, created, status'
        )->row();
        if (count($query_picture) <= 0)
            show_404();
        if ($query_picture->status == 0)
            show_error('Esta foto foi suspensa temporariamente', 404);
        $this->wpanel->set_meta_description($query_picture->descricao);
        $this->wpanel->set_meta_keywords('album, fotos');
        $this->wpanel->set_meta_title($query_picture->descricao);
        if(file_exists('./media/albuns/'.$query_picture->album_id.'/'.$query_picture->filename))
            $this->wpanel->set_meta_image(base_url('media/albuns/'.$query_picture->album_id.'/'.$query_picture->filename));
        $this->data_content['album']    = $query_album;
        $this->data_content['picture']  = $query_picture;
        $this->render('foto');
    }

    /**
     * The method videos() shows a list of videos from youtube. The videos is not
     * loaded automaticaly from the channel, it must be inserted into the control
     * panel by the manager.
     *
     * @return void
     */
    public function videos() 
    {
        $this->load->model('video');
        $query_videos = $this->video->get_by_field(
            'status', 
            1, 
            ['field' => 'created', 'order' => 'desc'],
            null,
            'link, titulo'
        )->result();
        $this->wpanel->set_meta_description('Lista de vídeos');
        $this->wpanel->set_meta_keywords('videos, filmes');
        $this->wpanel->set_meta_title('Vídeos');
        $this->data_content['videos']   = $query_videos;
        $this->data_content['max_cols'] = $this->wpn_cols_mosaic;
        $this->render('videos');
    }

    /**
     * The method video() shows a video selected by $code.
     *
     * @param $code string Youtube code for the video.
     * @return void
     */
    public function video($code = null) 
    {
        if ($code == null)
            show_404();
        $this->load->model('video');
        $query_video = $this->video->get_by_field(
            ['link'=>$code,'status'=>1], 
            null,
            null,
            null,
            'titulo, descricao, link, status'
        )->row();
        if (count($query_video) <= 0)
            show_404();
        if ($query_video->status == 0)
            show_error('Este vídeo foi suspenso temporariamente', 404);
        $this->data_content['video'] = $query_video;
        $this->wpanel->set_meta_description($query_video->titulo);
        $this->wpanel->set_meta_keywords('videos, filmes');
        $this->wpanel->set_meta_title($query_video->titulo);
        $this->wpanel->set_meta_image('http://img.youtube.com/vi/'.$code.'/0.jpg');
        $this->render('video');
    }

    /**
     * The method contato() creates a full functional 'Contact Page' for the site.
     *
     * @todo Criar a opção de inserir a mensagem no banco de dados e no painel de contorle.
     * @return void
     */
    public function contato() 
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('captcha', 'Confirmação', 'required|captcha');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        if ($this->form_validation->run() == FALSE) {
            $this->wpanel->set_meta_description('Formulário de contato');
            $this->wpanel->set_meta_keywords(' Contato, Fale Conosco');
            $this->wpanel->set_meta_title('Contato');
            $this->data_content['contact_content'] = $this->wpanel->get_config('texto_contato');
            $this->data_content['captcha'] = $this->form_validation->get_captcha();
            $this->render('contact');
        } else {
            // Receive the values of the form.
            $nome = $this->input->post('nome');
            $email = $this->input->post('email');
            $telefone = $this->input->post('telefone');
            $mensagem = $this->input->post('mensagem');
            // Make a message string.
            $msg = "";
            $msg .= "Mensagem enviada pelo site.\n\n";
            $msg .= "Nome: $nome\n";
            $msg .= "Email: $email\n";
            $msg .= "Telefone: $telefone\n\n";
            $msg .= "Mensagem\n";
            $msg .= "------------------------------------------------------\n\n";
            $msg .= "$mensagem";
            $msg .= "\n\n";
            $msg .= "Enviado pelo WPanel CMS\n";
            // Load the library.
            $this->load->library('email');
            // Check if use SMTP.
            if ($this->wpanel->get_config('usa_smtp') == 1) {
                $conf_email = array();
                $conf_email['protocol'] = 'smtp';
                $conf_email['smtp_host'] = $this->wpanel->get_config('smtp_servidor');
                $conf_email['smtp_port'] = $this->wpanel->get_config('smtp_porta');
                $conf_email['smtp_user'] = $this->wpanel->get_config('smtp_usuario');
                $conf_email['smtp_pass'] = $this->wpanel->get_config('smtp_senha');
                $this->email->initialize($conf_email);
                $this->email->from($this->wpanel->get_config('smtp_usuario'), 'Formulário de contato');
            } else {
                $this->email->from($email, $nome);
            }
            // Send the message.
            $this->email->to($this->wpanel->get_config('site_contato'));
            $this->email->subject('Mensagem do site - [' . $this->wpanel->get_titulo() . ']');
            $this->email->message($msg);
            // Verify the succes of the send.
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
     * The method rss() creates a XML page to Feed Readers with a list of posts.
     * 
     * @todo Criar o metodo de categorizar esta lista de feed.
     * @return void
     */
    public function rss()
    {
        $this->load->model('post');
        $query = $this->post->get_list(['field'=>'created', 'order'=>'desc'], null, '')->result();
        $available_languages = config_item('available_languages');
        $locale = $available_languages[wpn_config('language')]['locale'];
        $rss = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $rss .= "<rss version=\"2.0\">\n";
        $rss .= "\t<channel>\n";
        $rss .= "\t\t<title>" . wpn_config('site_titulo') . "</title>\n";
        $rss .= "\t\t<description>" . $this->wpanel->get_config('site_desc') . "</description>\n";
        $rss .= "\t\t<link>" . site_url() . "</link>\n";
        $rss .= "\t\t<language>".$locale."</language>\n";
        foreach ($query as $row) {
            $rss .= "\t\t<item>\n";
            $rss .= "\t\t\t<title>".$row->title."</title>\n";
            $rss .= "\t\t\t<description>".$row->description."</description>\n";
            $rss .= "\t\t\t<lastBuildDate>".$row->created."</lastBuildDate>\n";
            $rss .= "\t\t\t<link>" . site_url('post/' . $row->link) . "</link>\n";
            $rss .= "\t\t</item>\n";
        }
        $rss .= "\t</channel>\n</rss>\n";
        echo $rss;
    }

    /**
     * The method newsletter() show a form to insert contact for newsletter.
     *
     * @todo Enviar uma mensagem de confirmação do cadastro para o email.
     * @return void
     */
    public function newsletter()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
        if ($this->form_validation->run() == FALSE) {
            $this->wpanel->set_meta_description('Newsletter');
            $this->wpanel->set_meta_keywords('Cadastro, Newsletter');
            $this->wpanel->set_meta_title('Newsletter');
            $this->render('newsletter');
        } else {
            $this->load->model('newsletter');
            $dados_save = array(
                'nome' => $this->input->post('nome', true),
                'email' => $this->input->post('email', true),
                'created' => date('Y-m-d H:i:s'),
                'ipaddress' => $this->input->server('REMOTE_ADDR', true)
            );
            if ($this->newsletter->save($dados_save)) {
                $this->session->set_flashdata('msg_newsletter', 'Seus dados foram salvos com sucesso, obrigado!');
                redirect('newsletter');
            } else {
                $this->session->set_flashdata('msg_newsletter', 'Não foi possível salvar seus dados, verifique os erros e tente novamente.');
                redirect('newsletter');
            }
        }
    }
}