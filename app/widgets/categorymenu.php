<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorymenu extends Widget {

    private $category_id = '';
    private $attributes = '';
    private $item = '';

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
		return $this->get_category($this->category_id, $this->attributes, $this->item);
	}

    private function get_category($id = 0, $attributes = array(), $item = array())
    {
        $this->load->model('categoria');
        $str = '';
        $str .= '<ul ' . $this->_attributes($attributes) . '>';
        $query = $this->categoria->get_by_field('category_id', $id);
        foreach ($query->result() as $key => $value)
        {
            $str .= '<li ' . $this->_attributes($item) . '>' . anchor('/posts/' . $value->id . '/' . $value->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $value->title) . '</li>';
            $str .= $this->get_category($value->id, $attributes, $item);
        }
        $str .= '</ul>';
        return $str;
    }

}