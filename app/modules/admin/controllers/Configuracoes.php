<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Config class using json file.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Configuracoes extends Authenticated_admin_controller
{

    function __construct()
    {
        $this->model_file = array('category', 'post', 'configuracao');
        $this->language_file = 'wpn_configuration_lang';
        parent::__construct();
    }

    /**
     * Save the json config file.
     */
    public function index()
    {
        $configs = $this->configuracao->load_config();
        $category_check = '';
        $page_check = '';
        $smtp_checked = '';
        $this->form_validation->set_rules('site_titulo', wpn_lang('site_titulo'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $query_categorias = $this->category->order_by('title', 'asc')->find_all();
            $query_posts = $this->post->order_by('title', 'asc')->find_all();
            // Monta a lista de categorias.
            $opt_categoria = array();
            $opt_categoria[''] = wpn_lang('list_posts_from_all_categories');
            foreach ($query_categorias as $value)
            {
                $opt_categoria[$value->id] = $value->title;
            }
            // Monta a lista de postagens.
            $opt_posts = array();
            foreach ($query_posts as $value)
            {
                $opt_posts[$value->id] = $value->title;
            }
            // Organiza as caixas de checagem da configuração da página inicial.
            switch ($configs->home_tipo)
            {
                case 'category':
                    $category_check = 'checked';
                    $page_check = '';
                    $custom_check = '';
                    break;
                case 'page':
                    $category_check = '';
                    $page_check = 'checked';
                    $custom_check = '';
                    break;
                default:
                    $category_check = '';
                    $page_check = '';
                    $custom_check = 'checked';
                    break;
            }
            // Organiza as caixas de checagem do uso de SMTP.
            if ($configs->usa_smtp == 1)
                $smtp_checked = 'checked';
            else
                $smtp_checked = '';

            // Organiza as caixas de checagem do redimensionamento de imagens.
            if ($configs->resize_image == 1)
                $resize_checked = 'checked';
            else
                $resize_checked = '';

            if ($configs->maintain_ratio == 1)
                $ratio_checked = 'checked';
            else
                $ratio_checked = '';
            // Envia as variáveis para a view.
            $this->set_var('opt_categoria', $opt_categoria);
            $this->set_var('opt_posts', $opt_posts);
            $this->set_var('category_check', $category_check);
            $this->set_var('page_check', $page_check);
            $this->set_var('custom_check', $custom_check);
            $this->set_var('smtp_checked', $smtp_checked);
            $this->set_var('resize_checked', $resize_checked);
            $this->set_var('ratio_checked', $ratio_checked);
            $this->set_var('editor', $this->wpanel->load_editor());
            $this->set_var('row', $configs);
            $this->render();
        } else
        {
            $configs->site_titulo = $this->input->post('site_titulo');
            $configs->site_desc = $this->input->post('site_desc');
            $configs->site_tags = $this->input->post('site_tags');
            $configs->site_contato = $this->input->post('site_contato');
            $configs->site_telefone = $this->input->post('site_telefone');
            $configs->link_instagram = $this->input->post('link_instagram');
            $configs->link_twitter = $this->input->post('link_twitter');
            $configs->link_facebook = $this->input->post('link_facebook');
            $configs->link_likebox = $this->input->post('link_likebox');
            $configs->copyright = $this->input->post('copyright');
            $configs->addthis_uid = $this->input->post('addthis_uid');
            $configs->texto_contato = $this->input->post('texto_contato');
            $configs->google_analytics = $this->input->post('google_analytics');
            $configs->bgcolor = $this->input->post('bgcolor');
            $configs->language = $this->input->post('language');
            $configs->text_editor = $this->input->post('text_editor');
            $configs->author = $this->input->post('author');
            // Configurações da página inicial do site.
            $configs->home_tipo = $this->input->post('home_tipo');
            if ($this->input->post('home_tipo') == 'page')
                $configs->home_id = $this->input->post('home_post'); 
            else
                $configs->home_id = $this->input->post('home_category');
            // Smtp
            $configs->usa_smtp = $this->input->post('usa_smtp');
            $configs->smtp_servidor = $this->input->post('smtp_servidor');
            $configs->smtp_porta = $this->input->post('smtp_porta');
            $configs->smtp_crypto = $this->input->post('smtp_crypto');
            $configs->smtp_usuario = $this->input->post('smtp_usuario');
            $configs->smtp_senha = $this->input->post('smtp_senha');
            // Definições de redimensionamento das imagens das galerias.
            $configs->resize_image = $this->input->post('resize_image');
            $configs->maintain_ratio = $this->input->post('maintain_ratio');
            $configs->image_width = $this->input->post('image_width');
            $configs->image_height = $this->input->post('image_height');
            $configs->quality = $this->input->post('quality');
            // Definições de exibição de mídia.
            $configs->media_show_photo = $this->input->post('media_show_photo');
            $configs->media_show_video = $this->input->post('media_show_video');
            // Mantém os dados das imagens.
            $configs->logomarca = $configs->logomarca;
            $configs->background = $configs->background;
            if ($this->configuracao->save_config($configs))
                $this->set_message(wpn_lang('message_save_success'), 'success', 'admin/configuracoes');
            else
                $this->set_message(wpn_lang('message_save_error'), 'danger', 'admin/configuracoes');
        }
    }

    /**
     * Change logo image.
     */
    public function altlogo()
    {
        $configs = $this->configuracao->load_config();
        $this->wpanel->remove_media($configs->logomarca);
        $configs->logomarca = $this->wpanel->upload_media('', '*', 'logomarca');
        if ($this->configuracao->save_config($configs))
            $this->set_message(wpn_lang('message_logo_success'), 'success', 'admin/configuracoes');
        else
            $this->set_message(wpn_lang('message_logo_success'), 'danger', 'admin/configuracoes');
    }
    
    /**
     * Change favicon image.
     */
    public function altfavicon()
    {
        $configs = $this->configuracao->load_config();
        $this->wpanel->remove_media($configs->favicon);
        $configs->favicon = $this->wpanel->upload_media('', '*', 'favicon', 'favicon.ico');
        if ($this->configuracao->save_config($configs))
            $this->set_message(wpn_lang('message_favicon_success'), 'success', 'admin/configuracoes');
        else
            $this->set_message(wpn_lang('message_favicon_success'), 'danger', 'admin/configuracoes');
    }

    /**
     * Change the background image.
     */
    public function altback()
    {
        $configs = $this->configuracao->load_config();
        $this->wpanel->remove_media($configs->background);
        $configs->background = $this->wpanel->upload_media('', '*', 'background');
        if ($this->configuracao->save_config($configs))
            $this->set_message(wpn_lang('message_background_success'), 'success', 'admin/configuracoes');
        else
            $this->set_message(wpn_lang('message_background_success'), 'danger', 'admin/configuracoes');
    }

}
