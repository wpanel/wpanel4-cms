<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logomarca extends Widget {

    private $class_name = '';
    private $width = 'auto';

	function __construct($config = array())
	{
		if (count($config) > 0) {
            $this->initialize($config);
        }
	}

    public function initialize($config = array())
    {
        foreach ($config as $key => $val)
        {
            if (isset($this->$key)) {
                $method = 'set_' . $key;
                if (method_exists($this, $method)) {
                    $this->$method($val);
                } else {
                    $this->$key = $val;
                }
            }
        }
        return $this;
    }

    public function run()
	{
		$image_properties = array(
            'src' => base_url('media') . '/' . wpn_config('logomarca'),
            'class' => $this->class_name,
            'width' => $this->width
        );

        return img($image_properties);
	}

}