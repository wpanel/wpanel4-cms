<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Search form class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnsearchform extends Widget
{
    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $html = "";
        $html .= form_open('search', array('class' => 'form-inline', 'role' => 'form'));
        $html .= "<div class=\"form-group\">";
        $html .= "    <input type=\"text\" name=\"search\" class=\"form-control\" placeholder=\"Pesquisar ...\" />";
        $html .= "</div>";
        $html .= "<button type=\"submit\" class=\"btn btn-primary\">Ok</button>";

        $html .= form_close();

        return $html;
    }

}
