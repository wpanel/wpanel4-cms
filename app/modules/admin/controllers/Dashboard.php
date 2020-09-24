<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Control panel dashboard.
 *
 * @author Eliel de Paula <dev@gelieldepaula.com.br>
 * */
class Dashboard extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('post', 'banner', 'gallery', 'video');
        $this->language_file = 'wpn_dashboard_lang';
        parent::__construct();
        if (auth_login_data('role') == 'user')
            redirect('users');
    }

    /**
     * Index page.
     */
    public function index()
    {
        $data = array();
        $data['total_posts'] = $this->post->count_by(
                array(
                    'created_by' => $this->auth->user_id(),
                    'page' => 0,
                    'deleted' => 0
                )
        );
        $data['total_paginas'] = $this->post->count_by(
                array(
                    'created_by' => $this->auth->user_id(),
                    'page' => 1,
                    'deleted' => 0
                )
        );
        $data['total_agendas'] = $this->post->count_by(
                array(
                    'created_by' => $this->auth->user_id(),
                    'page' => 2,
                    'deleted' => 0
                )
        );
        $data['total_banners'] = $this->banner->count_by(
                array(
                    'created_by' => $this->auth->user_id(),
                    'deleted' => 0
                )
        );
        $data['total_albuns'] = $this->gallery->count_by(
                array(
                    'created_by' => $this->auth->user_id(),
                    'deleted' => 0
                )
        );
        $data['total_videos'] = $this->video->count_by(
                array(
                    'created_by' => $this->auth->user_id(),
                    'deleted' => 0
                )
        );
        $this->render($data);
    }

}
