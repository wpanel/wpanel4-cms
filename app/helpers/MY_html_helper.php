<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extensão para o helper HTML nativo do CodeIgniter.
 *
 * @author Eliel de Paula <elieldepaula@gmail.com>
 * @since 20/10/2014
 */


if ( ! function_exists('html_comment'))
{
	function html_comment($comment)
	{
		$str = "";
		$str = "<!-- ".$comment." -->\n";
		return $str;
	}
}

if ( ! function_exists('title'))
{
	function title($title)
	{
		$str = "";
		$str = "<title>".$title."</title>\n";
		return $str;
	}
}

if ( ! function_exists('html'))
{
	function html($close = FALSE)
	{
		$str = '';
		if($close){
			$str = "\n</html>";
		} else {
			$str = "<html>\n";
		}
		return $str;
	}
}

if ( ! function_exists('head'))
{
	function head($close = FALSE)
	{
		$str = '';
		if($close){
			$str = "</head>\n";
		} else {
			$str = "<head>\n";
		}
		return $str;
	}
}

if ( ! function_exists('body'))
{
	function body($attributes = '', $close = FALSE)
	{
		$str = '';
		if($close){
			$str = "\n</body>\n";
		} else {
			$str = "<body"._attributes($attributes).">\n";
		}
		return $str;
	}
}

if ( ! function_exists('div'))
{
	function div($attributes = '', $close = FALSE)
	{
		$str = '';
		if($close){
			$str = "\n</div>\n";
		} else {
			$str = "<div"._attributes($attributes).">\n";
		}
		return $str;
	}
}

if ( ! function_exists('hr'))
{
	function hr($attributes = '')
	{
			return "<hr"._attributes($attributes)."/>\n";
	}
}

if ( ! function_exists('_attributes'))
{

	/*
	| Passa os atributos passados em forma de array.
	*/
	function _attributes($attributes)
	{
		if(is_array($attributes))
		{
			$atr = '';
			foreach($attributes as $key => $value)
			{
				$atr .= " " . $key . "=\"".$value."\" ";
			}
			return $atr;
		} 
		elseif (is_string($attributes) and strlen($attributes) > 0) 
		{
			$atr = ' ' . $attributes;
		}
	}
}