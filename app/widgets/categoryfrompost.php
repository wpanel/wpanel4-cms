<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoryfrompost extends Widget {

    private $post_id = '';
    private $pre = '<span class="label label-primary">';
    private $pos = '</span>';

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

    public function set_post_id($var)
    {
        $this->post_id = $var;
    }

    public function set_pre($var)
    {
        $this->pre = $var;
    }

    public function set_pos($var)
    {
        $this->pos = $var;
    }

    public function run()
    {
        $str = '';
        $this->load->model('categoria');
        $this->load->model('post_categoria');
        foreach ($this->post_categoria->list_by_post($this->post_id)->result() as $value)
        {
            $str .= anchor(
                            'posts/' . $value->category_id, $this->categoria->get_title_by_id($value->category_id), array('class' => 'label label-warning')
                    ) . ' ';
        }
        return $str;
    }

}