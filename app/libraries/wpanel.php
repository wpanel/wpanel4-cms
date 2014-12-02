<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

/**
 * Biblioteca reunindo as opções mais comuns e frequentemente
 * utilizadas no funcionamento do wPanel.
 *
 * @package wPanel
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 26/10/2014
 **/
class wpanel
{

	private $meta_url = '';
	private $meta_description = '';
	private $meta_image = '';
	private $meta_keywords = '';
	private $meta_title = '';

	public function __construct($config = array()) 
	{
		if (count($config) > 0) 
		{
			$this->initialize($config);
		}
		log_message('debug', "Wpanel Class Initialized");
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
		if(is_array($attributes))
		{
			$atr = '';
			foreach($attributes as $key => $value)
			{
				$atr .= $key . "=\"".$value."\" ";
			}
			return $atr;
		} 
		elseif (is_string($attributes) and strlen($attributes) > 0) 
		{
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
				if (method_exists($this, $method)) 
				{
					$this->$method($val);
				}
				else 
				{
					$this->$key = $val;
				}
			}
		}
		return $this;
	}

	public function set_meta_url($value){
		$this->meta_url = $value;
	}

	public function set_meta_description($value){
		$this->meta_description = $value;
	}

	public function set_meta_image($value){
		$this->meta_image = $value;
	}

	public function set_meta_keywords($value){
		$this->meta_keywords = $value;
	}

	public function set_meta_title($value){
		$this->meta_title = $value;
	}

	/**
	 * Este método retorna o título da página.
	 *
	 * @return String
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 **/
	public function get_titulo()
	{
		if ($this->meta_title == '') 
		{
			return $this->get_config('site_titulo');
		} 
		else 
		{
			return $this->get_config('site_titulo') . ' - ' . $this->meta_title;
		}
	}

	/**
	 * Este método retorna um conjunto pronto de tags META para
	 * ser inserido no "head" do layout do site.
	 *
	 * @return mixed
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 **/
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
			array('name' => 'Content-type', 'content' => 'text/html; charset=' . config_item('charset'), 'type' => 'equiv'),
	        array('name' => 'robots', 'content' => 'all'),
	        array('name' => 'author', 'content' => config_item('meta_author')),
	        array('name' => 'canonical', 'content' => $this->meta_url),
	        array('name' => 'title', 'content' => $this->get_titulo()),
	        array('name' => 'description', 'content' => $description),
	        array('name' => 'keywords', 'content' => $this->get_config('site_tags') . ',' . $this->meta_keywords),
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
	 * Este método retorna um valor da tabela de configurações
	 * ou o objeto todo para ser selecionado externamente.
	 *
	 * Adicionado o recurso de retornar uma configuração do 
	 * arquivo 'config/wpanel.php'
	 *
	 * @return mixed
	 * @param $item String
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 **/
	public function get_config($item = '')
	{
		$this->load->model('configuracao');
		if ($item == '') {
			return $this->configuracao->get_by_id('1')->row();
		} 
		else 
		{
			$query = $this->configuracao->get_by_id('1')->row();
			return $query->$item;
		}		
	}

	/**
	 * Este método carrega as bibliotecas do editor de texto preferido
	 * nas telas onde são usados.
	 *
	 * @return Mixed
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 **/
	public function load_editor()
	{
		$str_out = '';
		if (config_item('text_editor') == 'tinymce') 
		{
			$str_out .= '<script src="'.base_url().'lib/tinymce/tinymce.min.js"></script>';
			$str_out .= '<script>tinymce.init({selector:\'textarea#editor\'});</script>';
			return $str_out;
		} 
		elseif (config_item('text_editor') == 'ckeditor') 
		{
			$str_out .= '<script type="text/javascript" src="'.base_url('').'lib/ckeditor/ckeditor.js"></script>';
			$str_out .= '<script>CKEDITOR.replace("editor");</script>';
			return $str_out;
		} 
		else 
		{
			return false;
		}
	}

	/**
	 * Este método lista as categorias a que uma postagem pertence e
	 * cria o link para a listagem de cada categoria.
	 *
	 * @return String
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 * @param $post_id Int Código da postagem.
	 **/
	public function categorias_do_post($post_id)
	{
		$str = '';
		$this->load->model('categoria');
		$this->load->model('post_categoria');
		foreach ($this->post_categoria->list_by_post($post_id)->result() as $value) 
		{
			$str .= anchor(
					'/posts/'.$value->category_id,
					$this->categoria->get_title_by_id($value->category_id),
					array('class'=>'label label-warning')
				).' ';
		}
		return $str;
	}

	/**
	 * Este método formata as tags de um post para exibição com bootstrap.
	 *
	 * @return String
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 * @param $args String Lista de tags separadas por vírgula.
	 **/
	public function prepare_tags($tags, $pre='<span class="label label-primary">', $pos='</span> ')
	{
		$str = '';
		$x = explode(',', $tags);
		foreach ($x as $value) 
		{
			$str .= $pre.$value.$pos;
		}
		return $str;
	}

	/**
	 * Este método faz a listagem das categorias e sub-categorias
	 * em forma de menu para ser exibido na sidebar do site.
	 *
	 * @return String
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 * @param $cat-pai Int Id da categoria pai.
	 **/
	public function menu_categorias($cat_pai=0, $attributes = array(), $item = array())
	{
		$this->load->model('categoria');
		$str = '';
		$str .= '<ul '.$this->_attributes($attributes).'>';
		$query = $this->categoria->get_by_field('category_id', $cat_pai);
		foreach ($query->result() as $key => $value)
		{
			$str .= '<li '.$this->_attributes($item).'>'.anchor('/posts/'.$value->id.'/'.$value->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $value->title).'</li>';
			$str .= $this->menu_categorias($value->id, $attributes, $item);
		}
		$str .= '</ul>';
		return $str;
	}

	/**
	 * Este método retorna uma lista de banners informando
	 * a posição.
	 *
	 * @return mixed
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 **/
	public function get_banner($position)
	{
		$this->load->model('banner');
		return $this->banner->get_banners($position)->result();
	}

} // END class wpanel