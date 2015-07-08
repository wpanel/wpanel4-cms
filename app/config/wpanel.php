<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

/**
 * Este arquivo contém as configurações a nível de desenvolvedor do wpanel
 * sendo que as configurações 'públicas' ficam armazenadas no banco de dados
 * para serem alteradas pelo administrador do site.
 *
 * @package Wpanel
 * @author Eliel de Paula <elieldepaula@gmail.com>
 * @since 07/11/2014
 */

/**
 * Defini a localidade do site para exibição nas meta-tags.
 */
$config['meta_locale'] = 'pt_BR';

/**
 * Defini as views disponíveis para a exibição das listas de postagens.
 */
$config['posts_views'] = array('lista' => 'main_posts', 'mosaico' => 'main_posts_mosaico');

/**
 * Defini qual editor online usará no painel de controle.
 * As opções são: 'tinymce' ou 'ckeditor'
 */
$config['text_editor'] = 'ckeditor';

/**
 * Defini a propriedade 'author' na tag 'meta' no header do site.
 */
$config['meta_author'] = 'Eliel de Paula <dev@elieldepaula.com.br>';

/**
 * Defini as posições dos banners no site para serem listados no 
 * painel de contorle.
 */
$config['pos_banners'] = array('slide' => 'Slide', 'sidebar' => 'Sidebar');
