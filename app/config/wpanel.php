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
 * Define os idiomas disponíveis. 
 */
$config['available_languages'] = array(
    'english'    => array('locale' => 'en', 'label' => 'Inglês'), 
    'portuguese' => array('locale' => 'pt_BR', 'label' => 'Português')
);

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
$config['banner_positions'] = array('slide' => 'Slide-Show', 'sidebar' => 'Barra lateral');

/**
 * Define os links funcionais para o gerenciador de menu.
 */
$config['funcional_links'] = array(
    'home'      => 'Página inicial',
    'contato'   => 'Página de contato',
    'albuns'    => 'Galeria de fotos',
    'videos'    => 'Galeria de videos',
    'events'    => 'Lista de eventos',
    'pool'      => 'Lista de enquetes',
    'users'     => 'Área do usuário',
    'rss'       => 'Página de RSS',
);