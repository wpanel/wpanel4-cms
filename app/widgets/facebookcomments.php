<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebookcomments extends Widget {

    private $link = '';

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
		$html = "";
        $html .= "<div class=\"fb-comments\" data-href=\"" . $this->link . "\" data-num-posts=\"15\" data-width=\"100%\"></div>";
        return $html;
	}

}