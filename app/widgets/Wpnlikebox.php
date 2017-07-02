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
 * Likebox class.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since v1.0.0
 */
class Wpnlikebox extends Widget
{

    protected $colorscheme = 'light';
    protected $show_faces = 'true';
    protected $header = 'false';
    protected $stream = 'false';
    protected $show_border = 'false';
    protected $width = '300';
    protected $height = '250';

    function __construct($config = array())
    {
        if (count($config) > 0)
            $this->initialize($config);
    }

    /**
     * Main method of the widget.
     * 
     * @return mixed
     */
    public function main()
    {
        return $this->likebox(
            $this->colorscheme, 
            $this->show_faces, 
            $this->header, 
            $this->stream, 
            $this->show_border, 
            $this->width, 
            $this->height
        );
    }

    /**
     * Return an HTML code of Facebook Likebox.
     * 
     * @param string $colorscheme
     * @param string $show_faces
     * @param string $header
     * @param string $stream
     * @param string $show_border
     * @param string $width
     * @param string $height
     * @return string
     */
    public function likebox($colorscheme = 'light', $show_faces = 'true', $header = 'false', $stream = 'false', $show_border = 'false', $width = '300', $height = '250')
    {
        $html = "";
        $html .= "<div class=\"fb-like-box\"
                        data-href=\"" . wpn_config('link_likebox') . "\"
                        data-colorscheme=\"" . $colorscheme . "\"
                        data-show-faces=\"" . $show_faces . "\"
                        data-header=\"" . $header . "\"
                        data-stream=\"" . $stream . "\"
                        data-show-border=\"" . $show_border . "\"
                        width=\"" . $width . "\"
                        height=\"" . $height . "\">
                    </div>";
        return $html;
    }

}
