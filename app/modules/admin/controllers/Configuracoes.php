<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->auth->protect('configuracoes');
    }

    public function index()
    {

        $configs = $this->wpanel->get_config();

        $layout_vars = array();
        $content_vars = array();
        $category_check = '';
        $page_check = '';
        $smtp_checked = '';

        $this->form_validation->set_rules('site_titulo', 'Título do site', 'required');

        if ($this->form_validation->run() == FALSE){

            $this->load->model('categoria');
            $this->load->model('post');

            $query_categorias = $this->categoria->get_list(['field'=>'title', 'order'=>'asc'], null, 'id, title')->result();
            $query_posts = $this->post->get_list(['field'=>'title', 'order'=>'asc'], null, 'id, title')->result();

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

            $dados_save = array();
            $dados_save['site_titulo'] = $this->input->post('site_titulo');
            $dados_save['site_desc'] = $this->input->post('site_desc');
            $dados_save['site_tags'] = $this->input->post('site_tags');
            $dados_save['site_contato'] = $this->input->post('site_contato');
            $dados_save['site_telefone'] = $this->input->post('site_telefone');
            $dados_save['link_instagram'] = $this->input->post('link_instagram');
            $dados_save['link_twitter'] = $this->input->post('link_twitter');
            $dados_save['link_facebook'] = $this->input->post('link_facebook');
            $dados_save['link_likebox'] = $this->input->post('link_likebox');
            $dados_save['copyright'] = $this->input->post('copyright');
            $dados_save['addthis_uid'] = $this->input->post('addthis_uid');
            $dados_save['texto_contato'] = $this->input->post('texto_contato');
            $dados_save['google_analytics'] = $this->input->post('google_analytics');
            $dados_save['bgcolor'] = $this->input->post('bgcolor');
            $dados_save['language'] = $this->input->post('language');

            // Configurações da página inicial do site.
            $dados_save['home_tipo'] = $this->input->post('home_tipo');
            if ($this->input->post('home_tipo') == 'page') {
                $dados_save['home_id'] = $this->input->post('home_post');
            } else {
                $dados_save['home_id'] = $this->input->post('home_category');
            }

            // Smtp
            $dados_save['usa_smtp'] = $this->input->post('usa_smtp');
            $dados_save['smtp_servidor'] = $this->input->post('smtp_servidor');
            $dados_save['smtp_porta'] = $this->input->post('smtp_porta');
            $dados_save['smtp_usuario'] = $this->input->post('smtp_usuario');
            $dados_save['smtp_senha'] = $this->input->post('smtp_senha');

            if ($this->input->post('alterar_logomarca') == '1') {
                $this->remove_image('logomarca');
                $dados_save['logomarca'] = $this->upload('logomarca');
            } else {
                $dados_save['logomarca'] = $configs->logomarca;
            }

            if ($this->input->post('alterar_background') == '1') {
                $this->remove_image('background');
                $dados_save['background'] = $this->upload('background');
            } else {
                $dados_save['background'] = $configs->background;
            }

            if ($this->configuracao->save_config($dados_save)) {
                $this->session->set_flashdata('msg_sistema', 'Configuração salva com sucesso.');
                redirect('admin/configuracoes');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Erro ao salvar a configuração.');
                redirect('admin/configuracoes');
            }
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

        $config['upload_path'] = './media/';
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
        $filename = './media/' . $config->$item;
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
