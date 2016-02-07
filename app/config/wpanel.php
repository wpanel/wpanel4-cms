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
 * Defini qual editor online usará no painel de controle.
 * As opções são: 'tinymce' ou 'ckeditor'
 */
$config['text_editor'] = 'ckeditor';

/**
 * Defini a propriedade 'author' na tag 'meta' no header do site.
 */
$config['meta_author'] = 'Eliel de Paula <dev@elieldepaula.com.br>';


//---- daqui para baixo permanece ----//

/**
 * Defini os idiomas disponíveis. 
 */
$config['available_languages'] = [
    'english'    =>['locale' => 'en', 'label' => 'Inglês'], 
    'portuguese' =>['locale' => 'pt_BR', 'label' => 'Português']
];

/**
 * Defini os tipos de usuário serão permitidos no site. 
 */
$config['users_role'] = ['user' => 'Usuário comum', 'admin' => 'Administrador'];

/**
 * Defini as views disponíveis para a exibição das listas de postagens.
 */
$config['posts_views'] = ['list' => 'Listagem', 'mosaic' => 'Mosaico'];

/**
 * Defini as posições dos banners no site para serem listados no 
 * painel de contorle.
 */
$config['banner_positions'] = ['slide' => 'Slide-Show', 'sidebar' => 'Barra lateral'];
