<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categoryfrompost extends Widget {

    private $post_id = '';
    private $pre = '<span class="label label-primary">';
    private $pos = '</span>';

	function __construct($config = array())
	{
		if (count($config) > 0)
            $this->initialize($config);
	}

    public function initialize($config = array())
    {
        foreach ($config as $key => $val){
            if (isset($this->$key)){
                $method = 'set_' . $key;
                if (method_exists($this, $method))
                    $this->$method($val);
                else
                    $this->$key = $val;
            }
        }
        return $this;
    }

    public function run()
    {
        $html = '';
        $this->load->model('categoria');
        $query = $this->categoria->get_by_post($this->post_id)->result();

        foreach ($query as $row){
            $html .= anchor('posts/'.$row->id.'/'.$row->link, $row->title, ['class' => 'label label-warning', 'style'=>'margin-right:5px;']);
        }
        return $html;
    }

}