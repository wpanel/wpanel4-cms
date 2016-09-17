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
 * Wpanel Library Class
 *
 * This class maintain the methods widely used in WpanelCms.
 *
 * @package     WpanelCms
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        https://wpanelcms.com.br
 * @version     0.0.1
 */
class Wpanel 
{

    /**
     * Config itens from config.json.
     * 
     * @var $wpanel_config mixed
     */
    protected $wpanel_config;
    
    /**
     * Description for meta tags.
     * 
     * @var $meta_description String
     */
    protected $meta_description = '';
    
    /**
     * Image for meta tags.
     * 
     * @var $meta_image string
     */
    protected $meta_image = '';
    
    /**
     * Key words for meta tags
     * 
     * @var $meta_keywords string
     */ 
    protected $meta_keywords = '';
    
    /**
     * Title for meta tags.
     * 
     * @var $meta_title string
     */
    protected $meta_title = '';

    /**
     * Class constructor.
     * 
     * @return void
     */
    public function __construct($config = array()) 
    {
        if (count($config) > 0)
            $this->initialize($config);
        try {
            
        } catch (Exception $e) {
            // echo $e->getMessage();
        }
        log_message('debug', "Wpanel Class Initialized");
    }

    /**
     * Get the instance of CI.
     * 
     * @return mixed
     */
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
     * Initialize the library loading the configuration files or
     * an array() passed on load of the class.
     *
     * @param $config array()
     * @return void
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
    
    /**
     * Check the first admin user.
     * 
     * @return mixed
     */
    public function check_setup()
	{
		$this->load->model('auth_model');
		if ($this->auth->accounts_empty() == TRUE)
			redirect('setup');
	}

    // ----- Encapsulation for meta tags | begin. ----- //
    public function set_meta_description($value)
    {
        $this->meta_description = $value;
    }

    public function get_meta_description() 
    {
        return $this->meta_description;
    }

    public function set_meta_image($value) 
    {
        $this->meta_image = $value;
    }

    public function get_meta_image() 
    {
        return $this->meta_image;
    }

    public function set_meta_keywords($value) 
    {
        $this->meta_keywords = $value;
    }

    public function get_meta_keywords() 
    {
        return $this->meta_keywords;
    }

    public function set_meta_title($value) 
    {
        $this->meta_title = $value .' | '. $this->get_config('site_titulo');
    }

    public function get_meta_title()
    {
        return $this->meta_title;
    }
    // ----- Encapsulation for meta tags | end. ----- //

    /* ----- Methods for the Website. ----- */
    
    /**
     * Return a full meta-tag to be inserted into the <head> of the site.
     *
     * @return mixed
     */
    public function get_meta() 
    {
        // Recupera a variável 'Locale'.
        $available_languages = config_item('available_languages');
        $locale = $available_languages[$this->get_config('language')]['locale'];
        // Trata a variável 'Description'.
        if (!$this->meta_description)
            $this->meta_description = $this->get_config('site_desc');
        // Trata a imagem de exibição.
        if(!$this->meta_image)
            $this->meta_image = base_url('media/'.$this->get_config('logomarca'));
        $meta = array(
            array('name' => 'Content-type', 'content' => 'text/html; charset=' . config_item('charset'), 'type' => 'equiv'),
            array('name' => 'robots', 'content' => 'all'),
            array('name' => 'author', 'content' => $this->get_config('author')),
            array('name' => 'canonical', 'content' => current_url()),
            array('name' => 'title', 'content' => $this->meta_title),
            array('name' => 'description', 'content' => $this->meta_description),
            array('name' => 'keywords', 'content' => $this->get_config('site_tags') . ', ' . $this->meta_keywords),
            // continua...
            //TODO Adicionar meta para o twitter e outras redes sociais.
            array('name' => 'og:locale', 'content' => $locale),
            array('name' => 'og:type', 'content' => 'article'),
            array('name' => 'og:image', 'content' => $this->meta_image),
            array('name' => 'og:title', 'content' => $this->meta_title),
            array('name' => 'og:description', 'content' => $this->meta_description),
            array('name' => 'og:url', 'content' => current_url()),
            array('name' => 'og:site_name', 'content' => $this->get_config('site_titulo')),
        );
        return meta($meta);
    }

    /**
     * Return a key value from the config.json file, or all the object if $item = null.
     *
     * @param $item String
     * @return mixed
     */
    public function get_config($item = null) 
    {
        $this->load->model('configuracao');
        return $this->configuracao->get_config($item);
    }

    /* ----- Methods for the Control Panel. ----- */

    /**
     * Return the code needed to load the configured editor.
     *
     * @return string
     * @todo Revisar este código de 'invocaçao' do editor.
     * @todo Adicionar o filemanager no tinyMCE.
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
     * Load the group of views to the control panel.
     * 
     * @param string $view
     * @param array $dados
     * @return mixed
     */
    public function load_view($view, $dados = null) 
    {
        $this->load->view('layout/header');
        $this->load->view($view, $dados);
        $this->load->view('layout/footer');
    }
}