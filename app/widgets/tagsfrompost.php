<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tagsfrompost extends Widget {

    private $tags = '';
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

    public function run()
    {
        $str = '';
        $x = explode(',', $this->tags);
        foreach ($x as $value)
        {
            $str .= $this->pre . $value . $this->pos . ' ';
        }
        return $str;
    }

}