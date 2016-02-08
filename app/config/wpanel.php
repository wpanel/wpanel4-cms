<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Este arquivo contém as configurações a nível de desenvolvedor do wpanel
 * sendo que as configurações 'públicas' ficam armazenadas no arquivo config.json
 * para serem alteradas pelo administrador do site no painel de controle.
 *
 * @package Wpanel
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 07/11/2014
 * Alterado em 8/02/2016
 */

/**
 * Define os idiomas disponíveis. 
 */
$config['available_languages'] = [
    'english'    =>['locale' => 'en', 'label' => 'Inglês'], 
    'portuguese' =>['locale' => 'pt_BR', 'label' => 'Português']
];

$config['available_editors'] = ['ckeditor'=>'CKEditor', 'tinymce'=>'TinyMCE'];

/**
 * Define os tipos de usuário serão permitidos no site. 
 */
$config['users_role'] = ['user' => 'Usuário comum', 'admin' => 'Administrador'];

/**
 * Define as views disponíveis para a exibição das listas de postagens.
 */
$config['posts_views'] = ['list' => 'Listagem', 'mosaic' => 'Mosaico'];

/**
 * Define as posições dos banners no site para serem listados no 
 * painel de contorle.
 */
$config['banner_positions'] = ['slide' => 'Slide-Show', 'sidebar' => 'Barra lateral'];
