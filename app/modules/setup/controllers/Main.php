<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class creates a initial database and a new admin user if the account 
 * table accounts was empty. Usually this occurs in the first run of Wpanel CMS
 * using the url [base-url]/index.php/setup
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Main extends MY_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Installation form.
     */
    public function index()
    {
        // Generate the initial database.
        $this->load->library('migration');
        $this->migration->latest();

        // Check if accounts is empty.
        if ($this->auth->accounts_empty() == FALSE)
            redirect('admin/login');

        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('name', 'Full name', 'required');
        $this->form_validation->set_rules('email', 'Valid email', 'required|valid_email');
        $this->form_validation->set_rules('agree', 'Terms of use', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->set_var('title', 'Setup');
            $this->render();
        } else {
            // Set App token.
            $this->load->model('configuracao');
            $this->load->library('wpanel');
            $configs = $this->configuracao->load_config();
            $configs->app_token = md5($this->input->post('email', TRUE) . time());
            $this->configuracao->save_config($configs);
            // Register the root user.
            $result = $this->auth->register(
                    $this->input->post('email', TRUE), $this->input->post('password', TRUE), 'ROOT', array(
                        'name' => $this->input->post('name'),
                        'skin' => 'blue',
                        'avatar' => ''
                    )
                );
            if ($result > 0) {
                // Activate the first user account.
                $this->auth->activate($result);
                $this->session->set_flashdata('msg_sistema', 'Account succefull created.');
                redirect('admin/login');
            } else {
                $this->session->set_flashdata('msg_sistema', 'Can´t create this account.');
                redirect('setup');
            }
        }
    }

}
