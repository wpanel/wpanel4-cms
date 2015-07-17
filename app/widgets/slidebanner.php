<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slidebanner extends Widget {

	private $position = '';
	private $classname = '';
	private $interval = '5000';
	private $cycle = 'true';

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

    public function set_position($var)
    {
    	$this->position = $var;
    }

    public function set_classname($var)
    {
    	$this->classname = $var;
    }

    public function set_interval($var)
    {
    	$this->interval = $var;
    }

    public function set_cycle($var)
    {
    	$this->cycle = $var;
    }

	public function run()
	{

		$this->load->model('banner');
        $query = $this->banner->get_banners($this->position)->result();

		$data = array(
			'banners' => $query,
			'classname' => $this->classname
		);
		$this->load->view('widgets/slidebanner', $data);
	}

}