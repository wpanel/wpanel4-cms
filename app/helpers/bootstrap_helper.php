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
 * Este helper gera os elementos do bootstrap 3 usando PHP
 * ao invés de HTML puro.
 *
 * Foi desenvolvido para ser usado no FrameWork CodeIgniter em conjunto
 * com o helper HTML e URL.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 20/10/2014
 **/

if ( ! function_exists('load_bootsrap'))
{
	/**
	 * Carrega o bootstrap.
	 **/
	function load_bootsrap()
	{

		$link = array(
			'href' => 'lib/css/bootstrap.css',
			'rel' => 'stylesheet',
			'type' => 'text/css'
		);

		return link_tag($link)."\n";

	}
}

if ( ! function_exists('_attributes'))
{

	/**
	 * Passa os atributos passados em forma de array.
	 **/
	function _attributes($attributes)
	{
		if(is_array($attributes))
		{
			$atr = '';
			foreach($attributes as $key => $value)
			{
				$atr .= $key . "=\"".$value."\" ";
			}
			return $atr;
		} 
		elseif (is_string($attributes) and strlen($attributes) > 0) 
		{
			$atr = ' ' . $attributes;
		}
	}
}

if ( ! function_exists('container'))
{
	/**
	 * Abre um container
	 **/
	function container($class = '', $id = '', $fluid = false)
	{
		$str = '';
		if($fluid)
		{
			$str = "container-fluid";
		} else {
			$str = "container";
		}

		return "<div class=\"".$str." ".$class."\" id=\"".$id."\">\n";

	}
}

if ( ! function_exists('row'))
{
	/**
	 * Abre uma linha - row
	 **/
	function row($class = '', $id = '')
	{
		return "<div class=\"row ".$class."\" id=\"".$id."\">\n";
	}
}

if ( ! function_exists('col'))
{
	/**
	 * Abre uma coluna - col-md-12
	 **/
	function col($num = '12', $size = 'md', $class = '', $id = '')
	{
		return "<div class=\"col-".$size."-".$num." ".$class."\" id=\"".$id."\">\n";
	}
}

if ( ! function_exists('close_div'))
{
	/**
	 * Fecha uma ou mais divs
	 **/
	function close_div($num = 1)
	{
		return str_repeat("</div>\n", $num);
	}
}

if ( ! function_exists('smalltext'))
{
	/**
	 * Gera um texto <small>
	 **/
	function smalltext($text)
	{
		$str = "";
		$str = "<small>".$text."</small>\n";
		return $str;
	}
}

if ( ! function_exists('button'))
{
	/**
	 * Gera um botão
	 **/
	function button($caption, $attributes = array())
	{
		$str = "";
		$str = "<button "._attributes($attributes).">".$caption."</button>\n";
		return $str;
	}
}

if ( ! function_exists('context_color'))
{
	/**
	 * Gera um parágrafo com as cores padrões do bootstrap.
	 **/
	function context_color($text, $tag = 'p', $style = 'primary')
	{
		$str = "";
		$str = "<".$tag." class=\"text-".$style."\">".$text."</".$tag.">\n";
		return $str;
	}
}

if ( ! function_exists('context_bg'))
{
	/**
	 * Gera um parágrafo com as cores de fundo padrões do bootstrap.
	 **/
	function context_bg($text, $tag = 'p', $style = 'primary')
	{
		$str = "";
		$str = "<".$tag." class=\"bg-".$style."\">".$text."</".$tag.">\n";
		return $str;
	}
}

if ( ! function_exists('clearfix'))
{

	/**
	 * Clearfix.
	 **/
	function clearfix()
	{
		return "<div class=\"clearfix\"></div>\n";
	}
}

if ( ! function_exists('glyphicon'))
{

	/**
	 * Gera um ícone.
	 **/
	function glyphicon($icon = 'star')
	{
		return "<span class=\"glyphicon glyphicon-".$icon."\"></span>\n";
	}
}

if ( ! function_exists('bread_crumb'))
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
	 **/
	function bread_crumb($itens)
	{
		$str = "";
		$str .= "<ol class=\"breadcrumb\">\n";

		foreach($itens as $item)
		{

			if($item['url'] == '')
			{
				$str .= "    <li class=\"active\">".$item['caption']."</li>\n";
			} else {
				$str .= "    <li>".anchor($item['url'], $item['caption'])."</li>\n";
			}
		}

		$str .= "</ol>\n";

		return $str;

	}
}

if ( ! function_exists('labels'))
{

	/**
	 * Gera um texto de label.
	 **/
	function labels($text, $style = 'default')
	{
		return "<span class=\"label label-".$style."\">".$text."</span>\n";
	}
}

if ( ! function_exists('badge'))
{

	/**
	 * Gera um texto de badge.
	 **/
	function badge($text)
	{
		return "<span class=\"badge\">".$text."</span>\n";
	}
}

if ( ! function_exists('page_header'))
{

	/**
	 * Gera um page-header.
	 **/
	function page_header($title, $size = 'h1', $subtitle = '')
	{
		$str = "";
		$str .= "<div class=\"page-header\">\n";
		$str .= "    <h".$size.">".$title." <small>".$subtitle."</small></h".$size.">\n";
		$str .= "</div>\n";

		return $str;
	}
}

if ( ! function_exists('alerts'))
{

	/**
	 * Gera um page-header.
	 **/
	function alerts($message, $style = 'info', $dismissible = FALSE)
	{
		$demiss = "";
		
		if($dismissible)
		{
			$demiss = " alert-dismissible";
		} 

		$str = "";
		$str .= "<div class=\"alert alert-".$style." ".$demiss."\" role=\"alert\">\n";
		$str .= "    <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
		$str .= "    ".$message."\n";
		$str .= "</div>\n";

		return $str;
	}
}