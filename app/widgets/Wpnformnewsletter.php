<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Form newsletter class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnformnewsletter extends Widget
{

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $this->view('formnewsletter');
    }

}
