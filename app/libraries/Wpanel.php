<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * -------------------------------------------------------------------------------------------------
 * Biblioteca reunindo as opções mais comuns e frequentemente
 * utilizadas no funcionamento do wPanel.
 *
 * @package wPanel
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 26/10/2014 - alterado em 8/02/2016
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
        if (count($config) > 0)
            $this->initialize($config);
        
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
        } elseif (is_string($attributes) and strlen($attributes) > 0)
            $atr = ' ' . $attributes;
        
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
                if (method_exists($this, $method))
                    $this->$method($val);
                else
                    $this->$key = $val;
                
            }
        }
        return $this;
    }

    // ----- Encapsulamento das variáveis META ----- //
    
    public function set_meta_description($value) {
        $this->meta_description = $value;
    }

    public function get_meta_description() {
        return $this->meta_description;
    }

    public function set_meta_image($value) {
        $this->meta_image = $value;
    }

    public function get_meta_image() {
        return $this->meta_image;
    }

    public function set_meta_keywords($value) {
        $this->meta_keywords = $value;
    }

    public function get_meta_keywords() {
        return $this->meta_keywords;
    }

    public function set_meta_title($value) {
        $this->meta_title = $value .' | '. $this->get_config('site_titulo');
    }

    public function get_meta_title(){
        return $this->meta_title;
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método retorna um conjunto pronto de tags META para
     * ser inserido no "head" do layout do site.
     *
     * @return mixed
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     */
    public function get_meta() {
        
        // Recupera a variável 'Locale'.
        $available_languages = config_item('available_languages');
        $locale = $available_languages[$this->get_config('language')]['locale'];

        // Trata a variável 'Description'.
        if (!$this->meta_description)
            $this->meta_description = $this->get_config('site_desc');

        // Trata a imagem de exibição.
        if(!$this->meta_image)
            $this->meta_image = base_url('media/'.$this->get_config('logomarca'));

        $meta = [
            ['name' => 'Content-type', 'content' => 'text/html; charset=' . config_item('charset'), 'type' => 'equiv'],
            ['name' => 'robots', 'content' => 'all'],
            ['name' => 'author', 'content' => $this->get_config('author')],
            ['name' => 'canonical', 'content' => current_url()],
            ['name' => 'title', 'content' => $this->meta_title],
            ['name' => 'description', 'content' => $this->meta_description],
            ['name' => 'keywords', 'content' => $this->get_config('site_tags') . ', ' . $this->meta_keywords],
            
            // continua...
            //TODO Adicionar meta para o twitter e outras redes sociais.

            ['name' => 'og:locale', 'content' => $locale],
            ['name' => 'og:type', 'content' => 'article'],
            ['name' => 'og:image', 'content' => $this->meta_image],
            ['name' => 'og:title', 'content' => $this->meta_title],
            ['name' => 'og:description', 'content' => $this->meta_description],
            ['name' => 'og:url', 'content' => current_url()],
            ['name' => 'og:site_name', 'content' => $this->get_config('site_titulo')],
        ];
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
        if($item)
            return $this->wpanel_config->$item;
        else
            return $this->wpanel_config;
        
    }

    /* ----- Métodos usados no painel de controle. ----- */

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
     * Este método faz o carregamento das views do painel de controle seguinto o novo
     * modelo de distribuição dos arquivos.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param string $view
     * @param array $dados
     * @return mixed
     * ---------------------------------------------------------------------------------------------
     */
    public function load_view($view, $dados = null) 
    {
        $this->load->view('layout/header');
        $this->load->view($view, $dados);
        $this->load->view('layout/footer');
    }

    public function get_from_user($param) 
    {
        $this->load->model('user');
        $query = $this->user->get_by_id($this->auth->get_userid())->row();
        return $query->$param;
    }

}

// END class wpanel