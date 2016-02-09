<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slidebanner extends Widget {

	private $position = '';
	private $class_name = '';
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

	public function run()
	{

		$this->load->model('banner');
        $query = $this->banner->get_by_field(
            ['position' => $this->position, 'status' => 1],
            null,
            ['field' => 'order', 'order' => 'asc'],
            null,
            'content'
        )->result();

		$data = array(
			'banners' => $query,
			'class_name' => $this->class_name
		);
		$this->load->view('widgets/slidebanner', $data);
	}

}