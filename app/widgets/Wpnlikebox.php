<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likebox class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnlikebox extends Widget
{

    protected $colorscheme = 'light';
    protected $show_faces = 'true';
    protected $header = 'false';
    protected $stream = 'false';
    protected $show_border = 'false';
    protected $width = '300';
    protected $height = '250';

    function __construct($config = array())
    {
        if (@count($config) > 0)
            $this->initialize($config);
    }

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        return $this->likebox(
            $this->colorscheme, 
            $this->show_faces, 
            $this->header, 
            $this->stream, 
            $this->show_border, 
            $this->width, 
            $this->height
        );
    }

    /**
     * Return an HTML code of Facebook Likebox.
     * 
     * @param string $colorscheme
     * @param string $show_faces
     * @param string $header
     * @param string $stream
     * @param string $show_border
     * @param string $width
     * @param string $height
     * @return string
     */
    public function likebox($colorscheme = 'light', $show_faces = 'true', $header = 'false', $stream = 'false', $show_border = 'false', $width = '300', $height = '250')
    {
        $html = "";
        $html .= "<div class=\"fb-like-box\"
                        data-href=\"" . wpn_config('link_likebox') . "\"
                        data-colorscheme=\"" . $colorscheme . "\"
                        data-show-faces=\"" . $show_faces . "\"
                        data-header=\"" . $header . "\"
                        data-stream=\"" . $stream . "\"
                        data-show-border=\"" . $show_border . "\"
                        width=\"" . $width . "\"
                        height=\"" . $height . "\">
                    </div>";
        return $html;
    }

}
