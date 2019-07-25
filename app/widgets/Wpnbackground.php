<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Background class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnbackground extends Widget
{

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {

        $html = "";
        $html .= "<style type=\"text/css\">\n";
        $html .= "\tbody {\n";
        if (wpn_config('background'))
            $html .= "\t\tbackground-image: url('" . base_url('media/' . wpn_config('background')) . "');\n";
        if (wpn_config('bgcolor'))
            $html .= "\t\tbackground-color: " . wpn_config('bgcolor') . ";\n";
        $html .= "\t}\n";
        $html .= "\t</style>\n";
        return $html;
    }

}
