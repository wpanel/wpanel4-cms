<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Configurações da biblioteca Auth()
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 01/10/2014
 */

$config['auth_table_name']		= 'users';
$config['auth_table_key']		= 'id';
$config['auth_username_field']	= 'email';
$config['auth_password_field']	= 'password';
$config['auth_status_field'] 	= 'status';
$config['auth_role_field'] 		= 'role';
$config['auth_permissions_field']	= 'permissions';
$config['auth_login_redirect']	= '/admin';
$config['auth_logout_redirect']	= '/admin/login';
$config['auth_msg_erro_login']	= 'Você precisa logar para acessar.';
$config['auth_msg_erro_fail']	= 'Seu login falhou, tente novamente.';
$config['auth_msg_erro_role']	= 'Você não tem permissão para acessar esta área.';

/**
 * Nesta seção, você pode adicionar ou remover os módulos
 * que estarão disponíveis para permissões no cadastro de
 * usuários do site.
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