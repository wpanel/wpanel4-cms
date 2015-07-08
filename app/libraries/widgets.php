<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class widgets {

	public function __construct($config = array())
    {
        if (count($config) > 0) {
            $this->initialize($config);
        }
        log_message('debug', "Widgets Class Initialized");
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }

    /**
     * Este método preenche uma lista de atributos passados
     * em forma de array em um elemento HTML
     *
     * @return mixed
     * @author Eliel de Paula <dev@elieldepaula.com.br>
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
     * Initialize the library loading the configuration files or
     * an array() passed on load of the class.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $config array()
     * @return void
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

    /* ----------------------------------------------------------------------------------------------------------- */

    public function site_description($class_name)
	{
		return "<div class=\"".$class_name."\" ><p>" . $this->wpanel->get_config('site_desc') . "</p></div>";
	}

	public function addthis_buttons()
	{
		$html = "";
		$html .= "<div class=\"addthis_toolbox addthis_default_style\">
                     <a class=\"addthis_button_facebook_like\" fb:like:layout=\"button_count\"></a>            
                     <a class=\"addthis_button_tweet\"></a>            
                     <a class=\"addthis_button_pinterest_pinit\"></a>            
                     <a class=\"addthis_counter addthis_pill_style\"></a>            
                 </div>";
		return $html;
	}

	public function post_tags($link, $pre = '<span class="label label-primary">', $pos = '</span> ')
    {
    	$this->load->model('post');
    	$post = $this->post->get_by_field('link', $link)->row();
        $str = '';
        $x = explode(',', $post->tags);
        foreach ($x as $value)
        {
            $str .= $pre . $value . $pos;
        }
        return $str;
    }

	public function likebox($colorscheme = 'light', $show_faces = 'true', $header = 'false', $stream = 'false', $show_border = 'false', $width = '300', $height = '250')
	{
		$html = "";
		$html .= "<div class=\"fb-like-box\"
                        data-href=\"" . $this->wpanel->get_config('link_likebox') . "\"
                        data-colorscheme=\"".$colorscheme."\"
                        data-show-faces=\"".$show_faces."\"
                        data-header=\"".$header."\"
                        data-stream=\"".$stream."\"
                        data-show-border=\"".$show_border."\"
                        width=\"".$width."\"
                        height=\"".$height."\">
                    </div>";
		return $html;
	}

	public function facebook_comments($link)
	{
		$html = "";
		$html .= "<div class=\"fb-comments\" data-href=\"" . site_url('post/' . $post->link) . "\" data-num-posts=\"15\" data-width=\"100%\"></div>";
		return $html;
	}

	public function form_newsletter()
	{
		$html = "";
		$html .= form_open('newsletter', array('role' => 'form'));
        $html .= "    <div class=\"form-group\">";
        $html .= "        <label class=\"control-label\" for=\"nome\">Nome</label>";
        $html .= "        <input class=\"form-control\" name=\"nome\" id=\"nome\" placeholder=\"Seu nome...\" type=\"text\">";
        $html .= "    </div>";
        $html .= "    <div class=\"form-group\">";
        $html .= "        <label class=\"control-label\" for=\"email\">Email</label>";
        $html .= "        <input class=\"form-control\" name=\"email\" id=\"email\" placeholder=\"Seu email...\" type=\"text\">";
        $html .= "    </div>";
        $html .= "    <button type=\"submit\" class=\"btn btn-primary\">";
        $html .= "        <span class=\"glyphicon glyphicon-envelope\"></span> Enviar";
        $html .= "    </button>";
        $html .= form_close();
		return $html;
	}

	public function form_search()
	{
		$html = "";
		$html .= form_open('search', array('class' => 'form-inline', 'role' => 'form'));
        $html .= "<div class=\"form-group\">";
        $html .= "    <input type=\"text\" name=\"search\" class=\"form-control\" placeholder=\"Pesquisar ...\" />";
        $html .= "</div>";
        $html .= "<button type=\"submit\" class=\"btn btn-primary\">Ok</button>";
        
        $html .= form_close();

		return $html;                            
	}

	public function events_menu($attributes = array())
    {
        $this->load->model('post');
        $query = $this->post->get_by_field(array('page' => '2', 'status' => '1'), null, array('field' => 'created', 'order' => 'desc'));
        $str = '';
        $str .= '<ul ' . $this->_attributes($attributes) . '>';
        foreach ($query->result() as $key => $value)
        {
            $str .= '<li>' . anchor('/post/' . $value->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $value->title) . '<br/><small>' . $value->description . '</small><br/><small>' . date('d/m/Y', strtotime($value->created)) . '</small></li>';
        }
        $str .= '</ul>';
        return $str;
    }

    public function category_menu($cat_pai = 0, $attributes = array(), $item = array())
    {
        $this->load->model('categoria');
        $str = '';
        $str .= '<ul ' . $this->_attributes($attributes) . '>';
        $query = $this->categoria->get_by_field('category_id', $cat_pai);
        foreach ($query->result() as $key => $value)
        {
            $str .= '<li ' . $this->_attributes($item) . '>' . anchor('/posts/' . $value->id . '/' . $value->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $value->title) . '</li>';
            $str .= $this->category_menu($value->id, $attributes, $item);
        }
        $str .= '</ul>';
        return $str;
    }

	public function bootstrap_banner($position, $class_name = 'hidden-xs wpn-banner')
	{
		
		$html = "";
        $html .= "<div class=\"row ".$class_name."\">\n";
        $html .= "    <div id=\"carousel-topo\" data-interval=\"false\" class=\"carousel slide\" data-ride=\"carousel\">\n";
        $html .= "        <div class=\"carousel-inner\">\n";
        
		// Laço com o banner slider.
		$laco = 0;
        foreach (wpn_banners($position) as $row) {
        	
            if ($laco == 0) {
        		$html .= "            <div class=\"item active\">\n";
        	} else {
        		$html .= "             <div class=\"item\">\n";
        	}
        
            $image_properties = array(
        		'src' => 'media/banners/' . $row->content,
        		'class' => '',
        	);

        	$html .= img($image_properties);
        	$html .= "</div>\n";

            $laco = $laco + 1;

        } // Fim do laço

        $html .= "        </div>\n";
        $html .= "        <!-- Ícones de navegação do slide. -->\n";
        $html .= "        <a class=\"left carousel-control\" href=\"#carousel-topo\" data-slide=\"prev\">\n";
        $html .= "            <span class=\"glyphicon glyphicon-chevron-left\"></span>\n";
        $html .= "        </a>\n";
        $html .= "        <a class=\"right carousel-control\" href=\"#carousel-topo\" data-slide=\"next\">\n";
        $html .= "            <span class=\"glyphicon glyphicon-chevron-right\"></span>\n";
        $html .= "        </a>\n";
        $html .= "    </div>\n";
        $html .= "</div>\n";
        $html .= "<!-- End - Banner slide -->\n";
        // Auto-play no banner
        $html .= "<script type=\"text/javascript\">\n";
	    $html .= "    var $ = jQuery.noConflict();\n";
	    $html .= "    $(document).ready(function () {\n";
	    $html .= "        $('#carousel-topo').carousel({interval: 5000, cycle: true});\n";
	    $html .= "    });\n";
	    $html .= "</script>\n";

		return $html;
	}
}