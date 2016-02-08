<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * -------------------------------------------------------------------------------------------------
 * Biblioteca reunindo as opções mais comuns e frequentemente
 * utilizadas no funcionamento do wPanel.
 *
 * @package wPanel
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 26/10/2014
 * -------------------------------------------------------------------------------------------------
 */
class Wpanel 
{

    protected $wpanel_config;
    protected $meta_description = '';
    protected $meta_image = '';
    protected $meta_keywords = '';
    protected $meta_title = '';

    public function __construct($config = array()) 
    {
        
        if (count($config) > 0) {
            $this->initialize($config);
        }

        $this->load->model('configuracao');
        $this->wpanel_config = $this->configuracao->load_config();

        log_message('debug', "Wpanel Class Initialized");
        
    }

    public function __get($var) 
    {
        return get_instance()->$var;
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método preenche uma lista de atributos passados
     * em forma de array em um elemento HTML
     *
     * @return mixed
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * ---------------------------------------------------------------------------------------------
     */
    private function _attributes($attributes) 
    {
        if (is_array($attributes)) {
            $atr = '';
            foreach ($attributes as $key => $value) {
                $atr .= $key . "=\"" . $value . "\" ";
            }
            return $atr;
        } elseif (is_string($attributes) and strlen($attributes) > 0) {
            $atr = ' ' . $attributes;
        }
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Initialize the library loading the configuration files or
     * an array() passed on load of the class.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $config array()
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function initialize($config = array()) 
    {
        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $method = 'set_' . $key;
                if (method_exists($this, $method)) {
                    $this->$method($val);
                } else {
                    $this->$key = $val;
                }
            }
        }
        return $this;
    }

    public function set_meta_description($value) {
        $this->meta_description = $value;
    }

    public function set_meta_image($value) {
        $this->meta_image = $value;
    }

    public function set_meta_keywords($value) {
        $this->meta_keywords = $value;
    }

    public function set_meta_title($value) {
        $this->meta_title = $value;
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método retorna o título da página.
     *
     * @return String
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * ---------------------------------------------------------------------------------------------
     */
    public function x_get_titulo() {
        if ($this->meta_title == '') {
            return $this->get_config('site_titulo');
        } else {
            return $this->get_config('site_titulo') . ' - ' . $this->meta_title;
        }
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método retorna um conjunto pronto de tags META para
     * ser inserido no "head" do layout do site.
     *
     * @return mixed
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @todo Não estou gostando deste método, tenho que melhorar a composição das tags 'meta'.
     */
    public function get_meta() {

        $description = "";
        $sitename = "";
        $url = "";
        $og_title = "";
        
        // temporario...
        $available_languages = config_item('available_languages');
        $locale = $available_languages[$this->get_config('language')]['locale'];

        // Trata a descrição.
        if ($this->meta_description == '') {
            $description = $this->get_config('site_desc');
        } else {
            $description = $this->meta_description;
        }

        if ($this->meta_title == '') {
            $og_title = $this->get_config('site_titulo');
        } else {
            $og_title = $this->meta_title;
        }

        $meta = array(
            array('name' => 'Content-type', 'content' => 'text/html; charset=' .
                config_item('charset'), 'type' => 'equiv'),
            array('name' => 'robots', 'content' => 'all'),
            array('name' => 'author', 'content' => $this->get_config('author')),
            array('name' => 'canonical', 'content' => current_url()),
            array('name' => 'title', 'content' => $this->get_config('site_titulo')),
            array('name' => 'description', 'content' => $description),
            array('name' => 'keywords', 'content' => $this->get_config('site_tags') . ',' .
                $this->meta_keywords),
            // continua...
            array('name' => 'og:locale', 'content' => $locale),
            array('name' => 'og:type', 'content' => 'article'),
            array('name' => 'og:image', 'content' => $this->meta_image),
            array('name' => 'og:title', 'content' => $og_title),
            array('name' => 'og:description', 'content' => $description),
            array('name' => 'og:url', 'content' => current_url()),
            array('name' => 'og:site_name', 'content' => $this->get_config('site_titulo')),
        );
        return meta($meta);
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método retorna um valor da tabela de configurações
     * ou o objeto todo para ser selecionado externamente.
     *
     * Adicionado o recurso de retornar uma configuração do 
     * arquivo 'config/wpanel.php'
     *
     * @todo Mudar esta função para um helper.
     * @return mixed
     * @param $item String
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * ---------------------------------------------------------------------------------------------
     */
    public function get_config($item = null) 
    {
        if($item){
            return $this->wpanel_config->$item;
        } else {
            return $this->wpanel_config;
        }
    }

    /**
     * Este método carrega as bibliotecas do editor de texto preferido
     * nas telas onde são usados.
     *
     * @return Mixed
     * @todo Revisar este código de 'invocaçao' do editor.
     */
    public function load_editor() 
    {
        $html = '';
        switch ($this->get_config('text_editor')) {
            case 'ckeditor':
                $html .= "\n\n<script type=\"text/javascript\" src=\"" . base_url('') . "lib/plugins/ckeditor/ckeditor.js\"></script>\n";
                return $html;
                break;
            case 'tinymce':
                $html .= '<script src="' . base_url() . 'lib/plugins/tinymce/tinymce.min.js"></script>';
                $html .= '<script>tinymce.init({selector:\'textarea#editor\',';
                $html .= '        plugins: [';
                $html .= '            "advlist autolink lists link image charmap print preview anchor",';
                $html .= '            "searchreplace visualblocks code fullscreen",';
                $html .= '            "insertdatetime media table contextmenu paste"';
                $html .= '        ],';
                $html .= '        menubar: false,';
                $html .= '        toolbar: " bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"';
                $html .= '});</script>';
                return $html;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método lista as categorias a que uma postagem pertence e
     * cria o link para a listagem de cada categoria.
     *
     * @return String
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $post_id Int Código da postagem.
     * ---------------------------------------------------------------------------------------------
     */
    public function category_of_post($post_id) {
        $str = '';
        $this->load->model('categoria');
        $this->load->model('post_categoria');
        foreach ($this->post_categoria->list_by_post($post_id)->result() as $value) {
            $str .= anchor(
                            'posts/' . $value->category_id, $this->categoria->get_title_by_id($value->category_id), array('class' => 'label label-warning')
                    ) . ' ';
        }
        return $str;
    }

    

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método retorna uma tag <img /> com a logomarca que estiver
     * configurada no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $var tipo descricao
     * @return void
     * ---------------------------------------------------------------------------------------------
     */
    public function x_get_logo() {
        $image_properties = array(
            'src' => base_url() . '/media/' . $this->wpanel->get_config('logomarca'),
            'class' => 'img-responsive hidden-xs',
            'width' => '200'
        );

        return img($image_properties);
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método retorna um código CSS para a exibição da imagem de 
     * fundo (background) configurada no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return String
     * ---------------------------------------------------------------------------------------------
     */
    public function get_background() {
        $html = "";
        $html .= "<style type=\"text/css\">
            body {
                background-image: url('" . base_url('media') . '/' .
                $this->wpanel->get_config('background') . "');
                background-color: " . $this->wpanel->get_config('bgcolor') . ";
            }
        </style>";
        return $html;
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método carrega a biblioteca externa do serviço AddThis(®)
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return String
     * ---------------------------------------------------------------------------------------------
     */
    public function get_header_addthis() {
        $html = "";
        $html .= "<script type=\"text/javascript\" src=\"//s7.addthis.com/js/300/addthis_widget.js
        #pubid=" . $this->wpanel->get_config('addthis_uid') . "\"></script>";
        return $html;
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método carrega o cabeçalho para o funcionamento dos widgets
     * do facebook(®) no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return String
     * ---------------------------------------------------------------------------------------------
     */
    public function get_header_facebook() {

        $html = "";
        $html .= "<div id=\"fb-root\"></div>\n";
        $html .= "<script>";
        $html .= "(function(d, s, id) {";
        $html .= "    var js, fjs = d.getElementsByTagName(s)[0];";
        $html .= "    if (d.getElementById(id))";
        $html .= "        return;";
        $html .= "    js = d.createElement(s);";
        $html .= "    js.id = id;";
        $html .= "    js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0\";";
        $html .= "    fjs.parentNode.insertBefore(js, fjs);";
        $html .= "        }(document, 'script', 'facebook-jssdk'));";
        $html .= "</script>";
        return $html;
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método carrega o código do GoogleAnalýtics(®) no site.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @return String
     * ---------------------------------------------------------------------------------------------
     */
    public function get_google_analytics() {
        return $this->wpanel->get_config('google_analytics');
    }

    /* ----- Métodos usados no painel de controle. ----- */

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método faz o carregamento das views do painel de controle seguinto o novo
     * modelo de distribuição dos arquivos.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param string $view
     * @param array $dados
     * @return mixed
     * ---------------------------------------------------------------------------------------------
     */
    public function load_view($view, $dados = null) {
        $this->load->view('layout/header');
        $this->load->view($view, $dados);
        $this->load->view('layout/footer');
    }

    public function get_from_user($param) {
        $this->load->model('user');
        $query = $this->user->get_by_id($this->auth->get_userid())->row();
        return $query->$param;
    }

}

// END class wpanel