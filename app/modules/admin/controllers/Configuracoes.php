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
 * --------------------------------------------------------------------------
 * Este é o controller de categorias, usado principalmente
 * no painel de controle do site.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 21/10/2014 - Alterado em 07/02/2016
 * --------------------------------------------------------------------------
 */
class Configuracoes extends MX_Controller 
{

    function __construct()
    {
        $this->auth->check_permission();
        parent::__construct();
    }

    /**
     * @todo Resolver a questão de enviar 2 uploads no mesmo formulário.
     */
    public function index()
    {

        $configs = $this->wpanel->get_config();
        $content_vars   = array();
        $category_check = '';
        $page_check     = '';
        $smtp_checked   = '';

        $this->form_validation->set_rules('site_titulo', 'Título do site', 'required');
        if ($this->form_validation->run() == FALSE){

            $this->load->model('categoria');
            $this->load->model('post');
            $query_categorias = $this->categoria->get_list(array('field'=>'title', 'order'=>'asc'), null, 'id, title')->result();
            $query_posts = $this->post->get_list(array('field'=>'title', 'order'=>'asc'), null, 'id, title')->result();

            // Monta a lista de categorias.
            $opt_categoria = array();
            $opt_categoria[''] = 'Listar postagens de todas as categorias.';
            foreach ($query_categorias as $value){
                $opt_categoria[$value->id] = $value->title;
            }
            // Monta a lista de postagens.
            $opt_posts = array();
            foreach ($query_posts as $value){
                $opt_posts[$value->id] = $value->title;
            }
            // Organiza as caixas de checagem da configuração da página inicial.
            switch ($configs->home_tipo){
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
            if ($configs->usa_smtp == 1){
                $smtp_checked = 'checked';
            } else {
                $smtp_checked = '';
            }
            // Envia as variáveis para a view.
            $content_vars['opt_categoria']  = $opt_categoria;
            $content_vars['opt_posts']      = $opt_posts;
            $content_vars['category_check'] = $category_check;
            $content_vars['page_check']     = $page_check;
            $content_vars['custom_check']   = $custom_check;
            $content_vars['smtp_checked']   = $smtp_checked;
            $content_vars['editor']         = $this->wpanel->load_editor();
            $content_vars['row']            = $configs;
            $this->wpanel->load_view('configuracoes/index', $content_vars);
            
        } else {
            
            $this->load->model('configuracao');

            $configs->site_titulo      = $this->input->post('site_titulo');
            $configs->site_desc        = $this->input->post('site_desc');
            $configs->site_tags        = $this->input->post('site_tags');
            $configs->site_contato     = $this->input->post('site_contato');
            $configs->site_telefone    = $this->input->post('site_telefone');
            $configs->link_instagram   = $this->input->post('link_instagram');
            $configs->link_twitter     = $this->input->post('link_twitter');
            $configs->link_facebook    = $this->input->post('link_facebook');
            $configs->link_likebox     = $this->input->post('link_likebox');
            $configs->copyright        = $this->input->post('copyright');
            $configs->addthis_uid      = $this->input->post('addthis_uid');
            $configs->texto_contato    = $this->input->post('texto_contato');
            $configs->google_analytics = $this->input->post('google_analytics');
            $configs->bgcolor          = $this->input->post('bgcolor');
            $configs->language         = $this->input->post('language');
            $configs->text_editor      = $this->input->post('text_editor');
            $configs->author           = $this->input->post('author');
            // Configurações da página inicial do site.
            $configs->home_tipo         = $this->input->post('home_tipo');
            if ($this->input->post('home_tipo') == 'page') {
                $configs->home_id      = $this->input->post('home_post');
            } else {
                $configs->home_id      = $this->input->post('home_category');
            }
            // Smtp
            $configs->usa_smtp         = $this->input->post('usa_smtp');
            $configs->smtp_servidor    = $this->input->post('smtp_servidor');
            $configs->smtp_porta       = $this->input->post('smtp_porta');
            $configs->smtp_usuario     = $this->input->post('smtp_usuario');
            $configs->smtp_senha       = $this->input->post('smtp_senha');
            // Mantém os dados das imagens.
            $configs->logomarca        = $configs->logomarca;
            $configs->background       = $configs->background;

            if ($this->configuracao->save_config($configs)) {
                $this->session->set_flashdata('msg_sistema', 'Configuração salva com sucesso.');
                redirect('admin/configuracoes');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar a configuração.');
                redirect('admin/configuracoes');
            }
        }
    }
    
    /**
     * Altera a logomarca.
     */
    public function altlogo()
    {
        $configs = $this->wpanel->get_config();
        $this->remove_image('logomarca');
        $configs->logomarca = $this->upload('logomarca');
        
        if ($this->configuracao->save_config($configs)) {
            $this->session->set_flashdata('msg_sistema', 'Configuração salva com sucesso.');
            redirect('admin/configuracoes');
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao salvar a configuração.');
            redirect('admin/configuracoes');
        }
    }
    
    /**
     * Altera a imagem de fundo.
     */
    public function altback()
    {
        $configs = $this->wpanel->get_config();
        $this->remove_image('background');
        $configs->background   = $this->upload('background');
        
        if ($this->configuracao->save_config($configs)) {
            $this->session->set_flashdata('msg_sistema', 'Configuração salva com sucesso.');
            redirect('admin/configuracoes');
        } else {
            $this->session->set_flashdata('msg_sistema', 'Erro ao salvar a configuração.');
            redirect('admin/configuracoes');
        }
    }

    /**
     * Este método faz o upload das imagens da logomarca e do background
     * do site para a pasta 'media'.
     *
     * @param $field_name string Nome do input que enviará o upload.
     * @return void
     */
    private function upload($field_name) 
    {

        $config['upload_path'] = APPPATH.'media/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '2000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['remove_spaces'] = TRUE;
        $config['overwrite'] = TRUE;
        $config['file_name'] = $field_name;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = array();
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        } else {
            return false;
        }
    }

    /**
     * Este método remove uma imagem de configuração da pasta
     * para evitar que a alteração de imagens gaste espaço
     * desnecessário no servidor.
     *
     * @param $item String Item de configuração.
     * @return boolean
     */
    private function remove_image($item) 
    {
        $config = $this->wpanel->get_config();
        $filename = APPPATH.'media/' . $config->$item;
        if (file_exists($filename)) {
            if (unlink($filename)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
