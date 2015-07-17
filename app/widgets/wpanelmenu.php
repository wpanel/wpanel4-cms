<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wpanelmenu extends Widget {

    private $menu_id = '';
    private $class_menu = '';
    private $class_item = '';

	function __construct($config = array())
	{
		if (count($config) > 0) {
            $this->initialize($config);
        }
	}

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

    public function run()
	{
		return $this->get_menu($this->menu_id, $this->class_menu, $this->class_item);
	}

    /**
     * ---------------------------------------------------------------------------------------------
     * Este método faz a exibição de um menu usando o ID como parametro principal.
     * 
     * O menu é gerado usando "<ul></ul>" e "<li></li>", os estilos pré-definidos são
     * os usados pelo Bootstrap, mas pode-se deixar os parametros de estilo em
     * branco e criar seus próprios estilos usando "ul li {}"
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param int $menu_id
     * @param string $class_menu
     * @param string $class_item
     * @return string|boolean
     * ---------------------------------------------------------------------------------------------
     */
    public function get_menu($menu_id = null, $class_menu = null, $class_item = null)
    {
        if ($menu_id == null) {
            return false;
        }
        $this->load->model('menu_item');
        $query = $this->menu_item->get_by_field('menu_id', $menu_id, array('field' => 'ordem', 'order' => 'asc'))->result();
        //TODO Criar a seleção de tipo de impressão ou estilo, para lista, coluna, em linha etc.
        $html = "";
        $html .= "<ul class=\"" . $class_menu . "\">";
        foreach ($query as $row)
        {
            if ($row->tipo == 'submenu') {
                $html .= "<li class=\"" . $class_item . " dropdown\">";
            } else {
                $html .= "<li class=\"" . $class_item . "\">";
            }
            switch ($row->tipo)
            {
                case 'link':
                    $html .= "<a href=\"" . $row->href . "\">" . $row->label . "</a>";
                    break;
                case 'post':
                    $html .= anchor('post/' . $row->href, $row->label);
                    break;
                case 'posts':
                    $html .= anchor('posts/' . $row->href, $row->label);
                    break;
                case 'funcional':
                    if ($row->href == 'home') {
                        $html .= anchor('', $row->label);
                    } else {
                        $html .= anchor($row->href, $row->label);
                    }
                    break;
                case 'submenu':
                    $html .= "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" >" . $row->label . " <span class=\"caret\"></span></a>";
                    $html .= $this->get_menu($row->href, 'dropdown-menu');
                    break;
            }
            $html .= "</li>";
        }

        $html .= "</ul>";
        return $html;
    }

}