<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tags from post class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpntagsfrompost extends Widget
{

    protected $tags = '';
    protected $pre = '<span class="label label-primary">';
    protected $pos = '</span>';

    function __construct($config = array())
    {
        if (count($config) > 0)
            $this->initialize($config);
    }

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        $str = '';
        $x = explode(',', $this->tags);
        foreach ($x as $value) {
            $str .= $this->pre . $value . $this->pos . ' ';
        }
        return $str;
    }

}
