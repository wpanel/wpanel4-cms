<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

/**
 * Define a lista de modulos para permissão do usuário.
 */
$config['modules'] = array(
	
    /*
    
    // Exemplo de configuração de módulo.
    array(
        'modulename' => '', 	// Nome do modulo
        'label' => '', 		// Label que será exibido no link dinâmico do painel de controle
        'link' => '', 		// Referência de link a partir de /admin/link, ex: 'pages'
        'description' => '',	// Descrição do módulo.
        'visible' => True, 	// Indica se o múdulo será ou não exibido no menu dinâmico co painel de controle.
    ),

    */
    array(
        'modulename' => 'agendas',
        'label' => 'Agendas',
        'link' => 'agendas',
        'description' => 'Gerenciador de agendas.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'albuns',
        'label' => 'Álbuns',
        'link' => 'albuns',
        'description' => 'Gerenciador de álbuns de foto.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'banners',
        'label' => 'Baners',
        'link' => 'banners',
        'description' => 'Gerenciador de banners.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'configuracoes',
        'label' => 'Configurações',
        'link' => 'configuracoes',
        'description' => 'Gerencia as configurações do site.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'menus',
        'label' => 'Menus',
        'link' => 'menus',
        'description' => 'Gerenciador de menu.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'newsletters',
        'label' => 'Newsletters',
        'link' => 'newsletters',
        'description' => 'Gerencia os emails coletados no cadastro de newsletter.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'pages',
        'label' => 'Páginas',
        'link' => 'pages',
        'description' => 'Gerencia as páginas fixas do site.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'posts',
        'label' => 'Postagens',
        'link' => 'posts',
        'description' => 'Gerencia as postagens do site.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'usuarios',
        'label' => 'Usuários',
        'link' => 'usuarios',
        'description' => 'Gerencia os usuários do painel de controle.',
        'visible' => True, 
    ),
    array(
        'modulename' => 'videos',
        'label' => 'Vídeos',
        'link' => 'videos',
        'description' => 'Gerencia os vídeos que serão disponibilizados no site.',
        'visible' => True, 
    ),
);