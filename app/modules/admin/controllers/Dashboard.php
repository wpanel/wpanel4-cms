<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Control panel dashboard.
 *
 * @author Eliel de Paula <dev@gelieldepaula.com.br>
 * @since v1.0.0
 * */
class Dashboard extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = array('post', 'banner', 'gallery', 'video');
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
