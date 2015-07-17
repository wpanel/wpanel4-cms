<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tagsfrompost extends Widget {

    private $link = '';
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

    public function set_link($var)
    {
        $this->link = $var;
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
        $this->load->model('post');
        $query = $this->post->get_by_field('link', $this->link)->row();
        $str = '';
        $x = explode(',', $query->tags);
        foreach ($x as $value)
        {
            $str .= $this->pre . $value . $this->pos . ' ';
        }
        return $str;
    }

}