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
		return $this->get_menu();
	}

    private function get_menu()
    {
        $this->load->model('post');
        $query = $this->post->get_by_field(
            array('page' => '2', 'status' => '1'), 
            null, 
            array('field' => 'created', 'order' => 'desc'),
            null,
            'title, link, description, created'
        );
        $html = '';
        $html .= '<ul ' . $this->_attributes($this->attributes) . '>';
        foreach ($query->result() as $key => $row)
        {
            $html .= '<li>' . anchor('/post/' . $row->link, '<span class="glyphicon glyphicon-chevron-right"></span> ' . $row->title) . '<br/><small>' . $row->description . '</small><br/><small>' . date('d/m/Y', strtotime($row->created)) . '</small></li>';
        }
        $html .= '</ul>';
        return $html;
    }

}