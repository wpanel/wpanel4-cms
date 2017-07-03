<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Addthis header class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnaddthisheader extends Widget
{

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $html = "";
        $html .= "<script type=\"text/javascript\" src=\"//s7.addthis.com/js/300/addthis_widget.js
        #pubid=" . wpn_config('addthis_uid') . "\"></script>";
        return $html;
    }

}
