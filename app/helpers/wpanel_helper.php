<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

if(!function_exists('get_asset'))
{
    /**
     * Esta função retorna o código de inclusão de umas
     * biblioteca CSS ou Java-Script. 
     *
     * @param $type string Tipo de bliblioteca, CSS ou JS.
     * @param $filename string Nome do arquivo a ser incluso. 
     * @return String 
     */
    function get_asset($type, $filename)
    {
        switch ($type) {
            case 'css':
                return "<link href=\"".base_url('assets')."/css/".$filename."\" rel=\"stylesheet\">\n";
                break;
            case 'js':
                return "<script src=\"".base_url('assets')."/js/".$filename."\" type=\"text/javascript\"></script>\n";
                break;
            case 'custom':
                return $filename;
                break;
        }
    }
}

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