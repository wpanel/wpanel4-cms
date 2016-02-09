<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categorymenu extends Widget {

    private $inicial_id = '0';
    private $main_attr = '';
    private $item_attr = '';

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

    public function run()
	{
		return $this->get_category($this->inicial_id);
	}

    private function get_category($id)
    {

        $this->load->model('categoria');
        $query = $this->categoria->get_by_field('category_id', $id, ['field'=>'title', 'order'=>'asc'], null, 'id, title, link')->result();

        $html = '';
        $html .= '<ul ' . $this->_attributes($this->main_attr) . '>';
        foreach ($query as $row){
            $html .= '<li ' . $this->_attributes($this->item_attr) . '>' . anchor('/posts/' . $row->id . '/' . $row->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $row->title) . '</li>';
            $html .= $this->get_category($row->id);
        }
        $html .= '</ul>';

        return $html;

    }

}