<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	var $wpn_profiler = FALSE;
	var $wpn_template = 'default';
	var $wpn_posts_view = 'lista';
    var $wpn_cols_mosaico = 2;
    // Define as variáveis mais usadas no controller.
    var $data_header = array();
    var $data_content = array();
    var $data_footer = array();

	function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler($this->wpn_profiler);

	}

	public function render($view) 
    {
                
        $this->load->view($this->wpn_template . '/header', $this->data_header);
        $this->load->view($this->wpn_template . '/' . $view, $this->data_content);
        $this->load->view($this->wpn_template . '/footer', $this->data_footer);

    }

}