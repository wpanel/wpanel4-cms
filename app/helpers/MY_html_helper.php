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
 * Aditional Html Helper of Codeigniter to WpanelCms.
 *
 * @package     WpanelCms
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        http://elieldepaula.com.br
 * @since       v1.0.0
 */

if (!function_exists('html_comment'))
{

    /**
     * Return an html comment tag.
     * @param string $comment Comment text.
     * @return string
     */
    function html_comment($comment)
    {
        $str = "";
        $str = "<!-- " . $comment . " -->\n";
        return $str;
    }

}

if (!function_exists('title'))
{

    /**
     * Return an title tag.
     * @param string $title
     * @return string
     */
    function title($title)
    {
        $str = "";
        $str = "<title>" . $title . "</title>\n";
        return $str;
    }

}

if (!function_exists('html'))
{

    /**
     * Return an html open or close tag.
     * 
     * @param boolean $close
     * @return string
     */
    function html($close = FALSE)
    {
        $str = '';
        if ($close)
            $str = "\n</html>";
        else
            $str = "<html>\n";
        return $str;
    }

}

if (!function_exists('head'))
{

    /**
     * Return an head openn or close tag.
     * 
     * @param boolean $close
     * @return string
     */
    function head($close = FALSE)
    {
        $str = '';
        if ($close)
            $str = "</head>\n";
        else
            $str = "<head>\n";
        return $str;
    }

}

if (!function_exists('body'))
{

    /**
     * Return an body open or close tag.
     * 
     * @param mixed $attributes
     * @param boolean $close
     * @return string
     */
    function body($attributes = '', $close = FALSE)
    {
        $str = '';
        if ($close)
            $str = "\n</body>\n";
        else
            $str = "<body" . _attributes($attributes) . ">\n";
        return $str;
    }

}

if (!function_exists('div'))
{

    /**
     * Return an div open or close tag.
     * 
     * @param mixed $attributes
     * @param boolean $close
     * @return string
     */
    function div($attributes = '', $close = FALSE)
    {
        $str = '';
        if ($close)
            $str = "\n</div>\n";
        else
            $str = "<div" . _attributes($attributes) . ">\n";
        return $str;
    }

}

if (!function_exists('hr'))
{

    /**
     * Return an hr tag.
     * 
     * @param mixed $attributes
     * @return string
     */
    function hr($attributes = '')
    {
        return "<hr" . _attributes($attributes) . "/>\n";
    }

}

if (!function_exists('_attributes'))
{

    /**
     * Return an attribute string for some tag.
     * 
     * @param mixed $attributes
     * @return string
     */
    function _attributes($attributes)
    {
        if (is_array($attributes))
        {
            $atr = '';
            foreach ($attributes as $key => $value)
            {
                $atr .= " " . $key . "=\"" . $value . "\" ";
            }
            return $atr;
        } elseif (is_string($attributes) and strlen($attributes) > 0)
            $atr = ' ' . $attributes;
    }

}