<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Define o template do site.
 */
$config['template'] = 'default';

/**
 * Define os delimitadores das mensagens de erro da biblioteca Validator.
 */
$config['validator_error_delimiters'] = array(
    'open' => '<p><span class="label label-danger">',
    'close' => '</span></p>'
);

/**
 * Define os idiomas disponíveis. 
 */
$config['available_languages'] = array(
    'english'    => array('locale' => 'en', 'label' => 'Inglês'), 
    'portuguese' => array('locale' => 'pt_BR', 'label' => 'Português')
);

/**
 * Define o formato das datas para o usuário.
 */
$config['user_date_format'] = '%d/%m/%Y';

/**
 * Define o formato das datas para o banco de dados.
 */
$config['db_date_format'] = '%Y-%m-%d';

/**
 * Define o formato das data e hora para o usuário.
 */
$config['user_datetime_format'] = '%d/%m/%Y %H:%i:%s';

/**
 * Define o formato das data e hora para o banco de dados.
 */
$config['db_datetime_format'] = '%Y-%m-%d %H:%i:%s';

/**
 * Define os editores de texto disponíveis no sistema.
 */
$config['available_editors'] = array('ckeditor'=>'CKEditor', 'tinymce'=>'TinyMCE');

/**
 * Define os tipos de usuário serão permitidos no site. 
 */
$config['users_role'] = array('user' => 'Usuário comum', 'admin' => 'Administrador');

/**
 * Define as views disponíveis para a exibição das listas de postagens.
 */
$config['posts_views'] = array('list' => 'Listagem', 'mosaic' => 'Mosaico');

/**
 * Define as posições dos banners no site para serem listados no 
 * painel de contorle.
 */
$config['banner_positions'] = array('slide', 'sidebar', 'footer');

/**
 * Define os links funcionais para o gerenciador de menu.
 */
$config['funcional_links'] = array(
    'home'      => 'Página inicial',
    'contact'   => 'Página de contato',
    'albuns'    => 'Galeria de fotos',
    'videos'    => 'Galeria de videos',
    'events'    => 'Lista de eventos',
    'pool'      => 'Lista de enquetes',
    'users'     => 'Área do usuário',
    'rss'       => 'Página de RSS',
);