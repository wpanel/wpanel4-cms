<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Site description class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnsitedescription extends Widget
{

    protected $classname = '';

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
        return "<div class=\"" . $this->classname . "\" ><p>" . wpn_config('site_desc') . "</p></div>";
    }

}
