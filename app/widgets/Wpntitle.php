<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Wpntitle extends Widget
{

    /**
     * Main method of the widget.
     *
     * @return string
     */
    public function main()
    {
        return "<title>" . $this->wpanel->get_meta_title() . "</title>\n";
    }

}