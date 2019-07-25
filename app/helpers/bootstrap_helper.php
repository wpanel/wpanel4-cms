<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Twitter Bootstrap 3 Helper for CodeIgniter.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
if (!function_exists('_attributes'))
{

    /**
     * Return the attributes.
     * 
     * @param $attributes Array of attributes: ['class'=>'row' ... ]
     * @return string
     */
    function _attributes($attributes)
    {
        if (is_array($attributes))
        {
            $atr = '';
            foreach ($attributes as $key => $value)
            {
                $atr .= $key . "=\"" . $value . "\" ";
            }
            return $atr;
        } elseif (is_string($attributes) and strlen($attributes) > 0)
            $atr = ' ' . $attributes;
    }

}

if (!function_exists('load_bootsrap'))
{

    /**
     * Load the bootstrap css file.
     *
     * @param $filename string Name of the css file.
     * @return string
     */
    function load_bootsrap($filename = 'bootstrap.min.css')
    {
        $link = array(
            'href' => 'assets/css/' . $filename,
            'rel' => 'stylesheet',
            'type' => 'text/css'
        );
        return link_tag($link) . "\n";
    }

}

if (!function_exists('container'))
{

    /**
     * Open a container.
     *
     * @param $class string class name
     * @param $id string Html object Id
     * @param $fluid boolean Defines if the cntainer is fluid.
     * @return string
     */
    function container($class = '', $id = '', $fluid = false)
    {
        $str = '';
        if ($fluid)
            $str = "container-fluid";
        else
            $str = "container";
        return "<div class=\"" . $str . " " . $class . "\" id=\"" . $id . "\">\n";
    }

}

if (!function_exists('row'))
{

    /**
     * Open a row line.
     * 
     * @param $class string Class name
     * @param $id string Html object Id
     * @return string
     */
    function row($class = '', $id = '')
    {
        return "<div class=\"row " . $class . "\" id=\"" . $id . "\">\n";
    }

}

if (!function_exists('col'))
{

    /**
     * Return a col tag: <div class="col-md-12">
     *
     * @param $num string Number of cols.
     * @param $size string Size of the col: xs, sm, md ...
     * @param $class string Extra class name.
     * @param $id string Html object ID.
     * @return string
     */
    function col($num = '12', $size = 'md', $class = '', $id = '')
    {
        return "<div class=\"col-" . $size . "-" . $num . " " . $class . "\" id=\"" . $id . "\">\n";
    }

}

if (!function_exists('close_div'))
{

    /**
     * Close a div tag: </div>
     *
     * @param $num int Num of tags.
     * @return string
     */
    function close_div($num = 1)
    {
        return str_repeat("</div>\n", $num);
    }

}

if (!function_exists('small_text'))
{

    /**
     * Return a small tag: <small>Some text</small>
     *
     * @param $text string Some text.
     * @return string
     */
    function small_text($text = '&nbsp;')
    {
        $str = "";
        $str = "<small>" . $text . "</small>\n";
        return $str;
    }

}

if (!function_exists('button'))
{

    /**
     * Return a button tag.
     *
     * @param $caption string Caption to the button.
     * @param $attributes array Attributes to the buttom: ['class'=>'some_class', ... ]
     * @return string
     * */
    function button($caption, $attributes = array())
    {
        $str = "";
        $str = "<button " . _attributes($attributes) . ">" . $caption . "</button>\n";
        return $str;
    }

}

if (!function_exists('context_color'))
{

    /**
     * Gera um parágrafo com as cores padrões do bootstrap.
     * */
    function context_color($text, $tag = 'p', $style = 'primary')
    {
        $str = "";
        $str = "<" . $tag . " class=\"text-" . $style . "\">" . $text . "</" . $tag . ">\n";
        return $str;
    }

}

if (!function_exists('context_bg'))
{

    /**
     * Gera um parágrafo com as cores de fundo padrões do bootstrap.
     * */
    function context_bg($text, $tag = 'p', $style = 'primary')
    {
        $str = "";
        $str = "<" . $tag . " class=\"bg-" . $style . "\">" . $text . "</" . $tag . ">\n";
        return $str;
    }

}

if (!function_exists('clearfix'))
{

    /**
     * Clearfix.
     * */
    function clearfix()
    {
        return "<div class=\"clearfix\"></div>\n";
    }

}

if (!function_exists('glyphicon'))
{

    /**
     * Gera um ícone.
     * */
    function glyphicon($icon = 'star')
    {
        return "<span class=\"glyphicon glyphicon-" . $icon . "\"></span>\n";
    }

}

if (!function_exists('bread_crumb'))
{

    /**
     * Gera um navegador estilo breadcrumb.
     * Os itens devem ser um array:
     *
     * array(
     *    array('link'=>'seu/link', 'caption'=>'Seu texto'),
     *    array('link'=>'seu/link', 'caption'=>'Seu texto'),
     *    array('caption'=>'Seu texto')
     * )
     *
     * */
    function bread_crumb($itens)
    {
        $str = "";
        $str .= "<ol class=\"breadcrumb\">\n";

        foreach ($itens as $item)
        {

            if ($item['url'] == '')
            {
                $str .= "    <li class=\"active\">" . $item['caption'] . "</li>\n";
            } else
            {
                $str .= "    <li>" . anchor($item['url'], $item['caption']) . "</li>\n";
            }
        }

        $str .= "</ol>\n";

        return $str;
    }

}

if (!function_exists('labels'))
{

    /**
     * Gera um texto de label.
     * */
    function labels($text, $style = 'default')
    {
        return "<span class=\"label label-" . $style . "\">" . $text . "</span>\n";
    }

}

if (!function_exists('badge'))
{

    /**
     * Gera um texto de badge.
     * */
    function badge($text)
    {
        return "<span class=\"badge\">" . $text . "</span>\n";
    }

}

if (!function_exists('page_header'))
{

	/**
	 * Gera um page-header.
	 **/
	function page_header($title, $size = '1', $subtitle = '')
	{
		$str = "";
		$str .= "<div class=\"page-header\">\n";
		$str .= "    <h".$size.">".$title." <small>".$subtitle."</small></h".$size.">\n";
		$str .= "</div>\n";

		return $str;
	}
}

if (!function_exists('alerts'))
{

    /**
     * Gera um page-header.
     * */
    function alerts($message, $style = 'info', $dismissible = FALSE)
    {
        $demiss = "";

        if ($dismissible)
        {
            $demiss = " alert-dismissible";
        }

        $str = "";
        $str .= "<div class=\"alert alert-" . $style . " " . $demiss . "\" role=\"alert\">\n";
        $str .= "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
        $str .= "    " . $message . "\n";
        $str .= "</div>\n";

        return $str;
    }

}