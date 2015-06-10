<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class newsletters extends MX_Controller
{

    function __construct()
    {
        $this->auth->protect('admin');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
    }

    public function index()
    {
        $content_vars = array();
        $this->load->model('newsletter');
        $contatos = $this->newsletter->get_list()->result();
        $content_vars['contatos'] = $contatos;
        $layout_vars['content'] = $this->load->view('newsletters_index', $content_vars, TRUE);
        $this->load->view('layout', $layout_vars);
    }

}
