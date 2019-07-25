<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Facebook header class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnfacebookheader extends Widget
{

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $html = "";
        $html .= "<div id=\"fb-root\"></div>\n";
        $html .= "<script>\n";
        $html .= "(function(d, s, id) {\n";
        $html .= "\tvar js, fjs = d.getElementsByTagName(s)[0];\n";
        $html .= "\tif (d.getElementById(id))\n";
        $html .= "\t    return;\n";
        $html .= "\tjs = d.createElement(s);\n";
        $html .= "\tjs.id = id;\n";
        $html .= "\tjs.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0\";\n";
        $html .= "\tfjs.parentNode.insertBefore(js, fjs);\n";
        $html .= "\t    }(document, 'script', 'facebook-jssdk'));\n";
        $html .= "</script>\n";
        return $html;
    }

}