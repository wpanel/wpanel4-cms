<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

/**
 * Configuração dos módulos disponíveis para a definição de permissões
 * de acesso no cadastro de usuários.
 */
$config['modules'] = array(
	
						/*
						// Exemplo de configuração de módulo.
						array(
							'modulename' => '', 	// Nome do modulo
							'label' => '', 			// Label que será exibido no link dinâmico do painel de controle
							'link' => '', 			// Referência de link a partir de /admin/link, ex: 'pages'
							'description' => '',	// Descrição do módulo.
							'visible' => True, 		// Indica se o múdulo será ou não exibido no menu dinâmico co painel de controle.
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
							'modulename' => 'dashboard',
							'label' => 'Dashboard',
							'link' => 'dashboard',
							'description' => 'Página inicial do WPanel.',
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