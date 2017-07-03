<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logomarca class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Wpnlogomarca extends Widget
{

    protected $class_name = '';
    protected $width = 'auto';

    /**
     * Class constructor.
     * 
     * @param mixed $config
     */
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
        $image_properties = array(
            'src' => base_url('media') . '/' . wpn_config('logomarca'),
            'class' => $this->class_name,
            'width' => $this->width
        );

        return img($image_properties);
    }

}
