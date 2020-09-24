<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe da biblioteca Wpanel.
 *
 * This class maintain the methods widely used in WpanelCms.

 * @author Eliel de Paula <dev@elieldepaula.com.br>
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
        log_message('debug', "Wpanel class initialized");
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
     * This method creates a list of HTML parametters sent by array.
     *
     * @return string
     */
    private function _attributes($attributes)
    {
        if (is_array($attributes))
        {
            $atr = '';
            foreach ($attributes as $key => $value)
            {
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
        foreach ($config as $key => $val)
        {
            if (isset($this->$key))
            {
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
     * Set the meta_description value.
     *
     * @param string $value
     */
    public function set_meta_description($value)
    {
        $this->meta_description = $value;
    }

    /**
     * Get the meta_descriptinon value.
     *
     * @return string
     */
    public function get_meta_description()
    {
        return $this->meta_description;
    }

    /**
     * Set the meta_image value.
     *
     * @param string $value
     */
    public function set_meta_image($value)
    {
        $this->meta_image = $value;
    }

    /**
     * Get the meta_image value
     *
     * @return string
     */
    public function get_meta_image()
    {
        return $this->meta_image;
    }

    /**
     * Set the meta_keywords value.
     *
     * @param string $value
     */
    public function set_meta_keywords($value)
    {
        $this->meta_keywords = $value;
    }

    /**
     * get the meta_keywords value.
     *
     * @return string
     */
    public function get_meta_keywords()
    {
        return $this->meta_keywords;
    }

    /**
     * Set the meta_title value.
     *
     * @param string $value
     */
    public function set_meta_title($value)
    {
        $this->meta_title = $value . ' | ' . $this->get_config('site_titulo');
    }

    /**
     * Get the meta_title value;
     *
     * @return string
     */
    public function get_meta_title()
    {
        return $this->meta_title;
    }

    /**
     * Return a full meta-tag to be inserted into the <head> of the site.
     *
     * @return mixed
     */
    public function get_meta()
    {
        $available_languages = config_item('available_languages');
        $locale = $available_languages[$this->get_config('language')]['locale'];
        if (!$this->meta_description)
            $this->meta_description = $this->get_config('site_desc');
        if (!$this->meta_image)
            $this->meta_image = base_url('media/' . $this->get_config('logomarca'));
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
        switch (wpn_config('text_editor'))
        {
            case 'ckeditor':
                $html .= "\n\n<script type=\"text/javascript\" src=\"" . base_url('lib/plugins/ckeditor/ckeditor.js') . "\"></script>\n";
                return $html;
                break;
            case 'tinymce':
                $html .= '<script src="' . base_url('lib/plugins/tinymce/tinymce.min.js') . '"></script>';
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
     * Send an email from the website.
     *
     * Example of array:
     *
     *    array(
     *        'html' => 'true/false',
     *        'from_name' => '',
     *        'from_email' => '',
     *        'to' => '',
     *        'subject' => '',
     *        'message' => '',
     *    )
     *
     * @param array $data
     * @return bool
     */
    public function send_email($data = NULL)
    {
        if ($data == NULL)
            return FALSE;
        // Load the library.
        $this->load->library('email');
        // Check if use SMTP.
        if (wpn_config("usa_smtp"))
        {
            $config['smtp_host'] = wpn_config("smtp_servidor");
            $config['smtp_user'] = wpn_config("smtp_usuario");
            $config['smtp_pass'] = wpn_config("smtp_senha");
            $config['smtp_port'] = wpn_config("smtp_porta");
            if (wpn_config("smtp_crypto") != '0')$config['smtp_crypto'] = wpn_config("smtp_crypto");
            $config['mailtype'] = $data['html'] ? 'html' : 'text';
            $config['validate'] = TRUE;
            $config['protocol'] = 'smtp';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;

            $this->email->initialize($config);
            $this->email->from(wpn_config('smtp_usuario'), wpn_config('site_titulo'));
        } else
        {
            $this->email->from($data['from_email'], wpn_config('site_titulo'));
        }

        // Send the message.
        $this->email->to($data['to']);
        $this->email->subject($data['subject']);
        $this->email->message($data['message']);

        // Verify the succes of the send.
        if ($this->email->send())
        {
            log_message('debug', $this->email->print_debugger() . " Success");
            return TRUE;
        } else
        {
            log_message('debug', $this->email->print_debugger() . " Error");
            return FALSE;
        }
    }

    /**
     * Upload a file.
     *
     * @param $path String Path where the file must be saved.
     * @param $types String File type: gif|jpg|png.
     * @param $fieldname String Field name of the form.
     * @param $filename String Optional file name..
     * @return mixed
     */
    public function upload_media($path, $types = '*', $fieldname = 'userfile', $filename = null)
    {
        $config['upload_path'] = FCPATH . 'media/' . $path . '/';
        $config['remove_spaces'] = TRUE;
        $config['file_ext_tolower'] = TRUE;
        $config['allowed_types'] = $types;
        if ($filename == null)
            $config['file_name'] = md5(date('YmdHis'));
        else
            $config['file_name'] = $filename;

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($fieldname))
        {
            $upload_data = array();
            $upload_data = $this->upload->data();

            if (wpn_config('resize_image') == 1)
            {
                $resize['image_library'] = 'gd2';
                $resize['source_image'] = $upload_data['full_path'];
                $resize['maintain_ratio'] = wpn_config('maintain_ratio');
                $resize['quality'] = wpn_config('quality');
                if (!wpn_config('image_width') == '')
                    $resize['width'] = $upload_data['image_width'] * str_replace('%', '', wpn_config('image_width')) / 100;
                if (!wpn_config('image_height') == '')
                    $resize['height'] = $upload_data['image_height'] * str_replace('%', '', wpn_config('image_height')) / 100;
                $this->load->library('image_lib', $resize);
                if (!$this->image_lib->resize())
                {
                    // print_r($resize);
                    // echo "<br/>";
                    // print_r($upload_data);
                    print_r($this->image_lib->display_errors());
                    exit;
                }
            }

            return $upload_data['file_name'];
        } else
            return false;
    }

    /**
     * Remove an uploaded file.
     *
     * @param $file String - Full path to the file.
     * @return boolean
     */
    public function remove_media($file)
    {
        $filename = FCPATH . 'media/' . $file;
        if (file_exists($filename))
        {
            if (unlink($filename))
                return TRUE;
            else
                return FALSE;
        } else
            return FALSE;
    }
    
    /**
     * Read an Json file and return the content as object.
     * 
     * @param string $filename Full path to the file.
     * @return mixed
     */
    public function read_json($filename = NULL)
    {
        
        if($filename == NULL)
            return FALSE;
        
        $json = file_get_contents($filename);
        $result = (object) json_decode($json);
        return $result;
        
    }
    
    /**
     * Write a Json file.
     * 
     * @param mixed $data Could be an Array or an Object.
     * @param string $filename Full path to the file.
     * @return boolean
     */
    public function write_json($data, $filename = NULL)
    {
        
        if($filename == NULL)
            return FALSE;
        
        $json = json_encode($data);
        if (write_file($filename, $json))
            return TRUE;
        else
            return FALSE;
        
    }
    
}
