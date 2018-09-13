<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Aditional Html Helper of Codeigniter to WpanelCms.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
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