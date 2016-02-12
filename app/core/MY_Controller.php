<?php 

/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
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
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller Controller Class
 *
 * This class maintain the common code for the WpanelCMS Controllers.
 *
 * @package     WpanelCms
 * @subpackage  Core
 * @category    Core
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        https://wpanelcms.com.br
 * @version     0.0.1
 */
class MY_Controller extends CI_Controller {

    /**
    * Enable or disable CodeIgniter profiler.
    * 
    * $var $wpn_profiler
    */
	var $wpn_profiler = FALSE;

    /**
    * Default template folder.
    * 
    * $var $wpn_template
    */
	var $wpn_template = 'default';

    /**
    * Default posts view list.
    * 
    * $var $wpn_posts_view
    */
	var $wpn_posts_view = 'list';

    /**
    * Default column number.
    * 
    * $var $wpn_cols_mosaic
    */
    var $wpn_cols_mosaic = 3;

    /**
    * Common data to header view.
    * 
    * $var $data_header
    */
    var $data_header = array();

    /**
    * Common data to content view.
    * 
    * $var $data_content
    */
    var $data_content = array();

    /**
    * Common data to footer.
    * 
    * $var $data_footer
    */
    var $data_footer = array();

    /**
    * Class constructor.
    *
    * @return void
    */
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler($this->wpn_profiler);
	}

    /**
    * The render () method encapsulates the common code of views. It was 
    * thought that you will carry the views header, content and footer 
    * on each method in the controller.
    *
    * If you need to, you can change this method depending on your project.
    *
    * @param $view string Name of the view.
    * @return void
    */
	public function render($view) 
    {
        $this->load->view($this->wpn_template.'/header', $this->data_header);
        $this->load->view($this->wpn_template.'/'.$view, $this->data_content);
        $this->load->view($this->wpn_template.'/footer', $this->data_footer);
    }
}