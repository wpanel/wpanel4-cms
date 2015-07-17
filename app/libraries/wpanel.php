<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
class wpanel
{

    private $meta_url = '';
    private $meta_description = '';
    private $meta_image = '';
    private $meta_keywords = '';
    private $meta_title = '';

    public function __construct($config = array())
    {
        if (count($config) > 0) {
            $this->initialize($config);
        }
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
            foreach ($attributes as $key => $value)
            {
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
        foreach ($config as $key => $val)
        {
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

    public function set_meta_url($value)
    {
        $this->meta_url = $value;
    }

    public function set_meta_description($value)
    {
        $this->meta_description = $value;
    }

    public function set_meta_image($value)
    {
        $this->meta_image = $value;
    }

    public function set_meta_keywords($value)
    {
        $this->meta_keywords = $value;
    }

    public function set_meta_title($value)
    {
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
    public function get_titulo()
    {
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
     * ---------------------------------------------------------------------------------------------
     */
    public function get_meta()
    {

        $description = "";
        $sitename = "";
        $url = "";
        $og_title = "";

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
            array('name' => 'author', 'content' => config_item('meta_author')),
            array('name' => 'canonical', 'content' => $this->meta_url),
            array('name' => 'title', 'content' => $this->get_titulo()),
            array('name' => 'description', 'content' => $description),
            array('name' => 'keywords', 'content' => $this->get_config('site_tags') . ',' . 
                $this->meta_keywords),
            // continua...
            array('name' => 'og:locale', 'content' => config_item('meta_locale')),
            array('name' => 'og:type', 'content' => 'article'),
            array('name' => 'og:image', 'content' => $this->meta_image),
            array('name' => 'og:title', 'content' => $og_title),
            array('name' => 'og:description', 'content' => $description),
            array('name' => 'og:url', 'content' => $this->meta_url),
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
     * @return mixed
     * @param $item String
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * ---------------------------------------------------------------------------------------------
     */
    public function get_config($item = '')
    {
        $this->load->model('configuracao');
        if ($item == '') {
            return $this->configuracao->get_by_id('1')->row();
        } else {
            $query = $this->configuracao->get_by_id('1')->row();
            return $query->$item;
        }
    }

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método carrega as bibliotecas do editor de texto preferido
     * nas telas onde são usados.
     *
     * @return Mixed
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * ---------------------------------------------------------------------------------------------
     */
    public function load_editor()
    {
        $str_out = '';
        if (config_item('text_editor') == 'tinymce') {
            $str_out .= '<script src="' . base_url() . 'lib/plugins/tinymce/tinymce.min.js"></script>';
            $str_out .= '<script>tinymce.init({selector:\'textarea#editor\',';
            $str_out .= '        plugins: [';
            $str_out .= '            "advlist autolink lists link image charmap print preview anchor",';
            $str_out .= '            "searchreplace visualblocks code fullscreen",';
            $str_out .= '            "insertdatetime media table contextmenu paste"';
            $str_out .= '        ],';
            $str_out .= '        menubar: false,';
            $str_out .= '        toolbar: " bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"';
            $str_out .= '});</script>';
            return $str_out;
        } elseif (config_item('text_editor') == 'ckeditor') {
            $str_out .= '<script type="text/javascript" src="' . base_url('') . 'lib/plugins/ckeditor/ckeditor.js"></script>';
            $str_out .= '<script>CKEDITOR.replace("editor");</script>';
            return $str_out;
        } else {
            return false;
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
    // public function categorias_do_post($post_id)
    // {
    //     $str = '';
    //     $this->load->model('categoria');
    //     $this->load->model('post_categoria');
    //     foreach ($this->post_categoria->list_by_post($post_id)->result() as $value)
    //     {
    //         $str .= anchor(
    //                         'posts/' . $value->category_id, $this->categoria->get_title_by_id($value->category_id), array('class' => 'label label-warning')
    //                 ) . ' ';
    //     }
    //     return $str;
    // }

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
	public function get_logo()
	{
		$image_properties = array(
        	'src' => base_url() . '/media/' . $this->wpanel->get_config('logomarca'),
        	'class' => 'img-responsive hidden-xs'
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
	public function get_background()
	{
		$html  = "";
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
	public function get_header_addthis()
	{
		$html  = "";
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
	public function get_header_facebook()
	{

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
	public function get_google_analytics()
	{
		return $this->wpanel->get_config('google_analytics');
	}

}

// END class wpanel