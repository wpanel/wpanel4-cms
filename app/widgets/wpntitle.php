<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wpntitle extends Widget {

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
        $html .= "<title>".$this->wpanel->get_meta_title()."</title>\n";
        return $html;
	}

}