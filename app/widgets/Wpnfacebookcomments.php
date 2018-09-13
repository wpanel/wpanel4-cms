<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Facebook comments class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnfacebookcomments extends Widget
{

    /**
     * URI
     * @var string
     */
    protected $link = '';

    /**
     * Class constructor.
     * @param mixed $config
     */
    function __construct($config = array())
    {
        if (count($config) > 0) {
            $this->initialize($config);
        }
    }

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $html = "";
        $html .= "<div class=\"fb-comments\" data-href=\"" . $this->link . "\" data-num-posts=\"15\" data-width=\"100%\"></div>";
        return $html;
    }

}
