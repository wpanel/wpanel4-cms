<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Likebox extends Widget {

	private $colorscheme = 'light';
	private $show_faces = 'true';
	private $header = 'false';
	private $stream = 'false';
	private $show_border = 'false';
	private $width = '300';
	private $height = '250';

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

	public function run(){

		return $this->likebox(
			$this->colorscheme, 
			$this->show_faces, 
			$this->header, 
			$this->stream, 
			$this->show_border, 
			$this->width, 
			$this->height);
	}

	public function likebox($colorscheme = 'light', $show_faces = 'true', $header = 'false', $stream = 'false', $show_border = 'false', $width = '300', $height = '250')
	{
		$html = "";
		$html .= "<div class=\"fb-like-box\"
                        data-href=\"" . $this->wpanel->get_config('link_likebox') . "\"
                        data-colorscheme=\"".$colorscheme."\"
                        data-show-faces=\"".$show_faces."\"
                        data-header=\"".$header."\"
                        data-stream=\"".$stream."\"
                        data-show-border=\"".$show_border."\"
                        width=\"".$width."\"
                        height=\"".$height."\">
                    </div>";
		return $html;
	}

}