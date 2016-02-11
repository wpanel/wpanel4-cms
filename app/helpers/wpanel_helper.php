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
 * -------------------------------------------------------------------------------------------------
 * Este helper contém as funções utilitárias específicas do wPanel.
 *
 * Foi desenvolvido para ser usado no FrameWork CodeIgniter em conjunto
 * com o helper HTML e URL e Bootstrap-Helper.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 21/10/2014
 * -------------------------------------------------------------------------------------------------
 */

if(!function_exists('wpn_asset'))
{
    /**
     * Esta função retorna o código de inclusão de umas
     * biblioteca CSS ou Java-Script. 
     *
     * @param $type string Tipo de bliblioteca, CSS ou JS.
     * @param $filename string Nome do arquivo a ser incluso. 
     * @return String 
     */
    function wpn_asset($type, $filename)
    {
        switch ($type) {
            case 'css':
                return "<link href=\"".base_url('assets/css/'.$filename)."\" rel=\"stylesheet\">\n";
                break;
            case 'js':
                return "<script src=\"".base_url('assets/js/'.$filename)."\" type=\"text/javascript\"></script>\n";
                break;
            case 'custom':
                return $filename;
                break;
        }
    }
}

if(!function_exists('wpn_config')){

    /**
     * Esta função retorna um item de configuração do arquivo
     * config.json, ele funciona como um atalho para o método
     * $CI->wpanel->get_config()
     *
     * @param $item mixed Item de configuração.
     * @return mixed 
     */
    function wpn_config($item = null)
    {
        $CI =& get_instance();
        return $CI->wpanel->get_config($item);
    }
}

if(!function_exists('wpn_meta')){

    /**
     * Esta função retorna um item de configuração do arquivo
     * config.json, ele funciona como um atalho para o método
     * $CI->wpanel->get_config()
     *
     * @return mixed 
     */
    function wpn_meta()
    {
        $CI =& get_instance();
        return $CI->wpanel->get_meta();
    }
}

if(!function_exists('wpn_widget')){

    /**
     * Esta função retorna um widget, ela funciona como um atalho
     * para o método $this->widget->runit();
     *
     * @param $widget_name string Nome do widget.
     * @param $args array Parametros do widget.
     * @return mixed 
     */
    function wpn_widget($widget_name, $args = [])
    {
        $CI =& get_instance();
        return $CI->widget->runit($widget_name, $args);
    }
}

if(!function_exists('wpn_fakelink')){

    function wpn_fakelink($var)
    {
        return strtolower(url_title(convert_accented_characters($var)));
    }
}

/* ----- Funções usadas somente no painel de controle ----- */

if (!function_exists('link_ativo')) {
    
    /**
     * Este helper retorna uma class de ativação dos links do bootstrap.
     * 
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param string $link
     * @return string class="active"
     */
    function link_ativo($link) {
        $CI =& get_instance();
        if ($CI->uri->segment(2) == $link) {
            return ' class="active"';
        }
    }
}

if (!function_exists('status_post')) {

    /**
     * Esta função gera um label do bootstrap 3 de acordo com o status do post.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $status int - Status do post.
     * @return string
     * */
    function status_post($status)
    {
        if ($status == '1') {
            return '<span class="label label-success">Publicado</span>';
        } else {
            return '<span class="label label-danger">Indisponível</span>';
        }
    }

}

if (!function_exists('status_user')) {

    /**
     * Esta função gera um label de acordo com o status do usuário.
     *
     * @author Eliel de Paula <dev@elieldepaula.com.br>
     * @param $status int - Status do usuário
     * @return string
     * */
    function status_user($status)
    {
        if ($status == '1') {
            return '<span class="label label-success">Ativo</span>';
        } else {
            return '<span class="label label-danger">Bloqueado</span>';
        }
    }

}