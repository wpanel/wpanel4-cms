<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eventsmenu extends Widget {

    private $attributes = '';

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
		return $this->get_menu($this->attributes);
	}

    private function get_menu($attributes = array())
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

}