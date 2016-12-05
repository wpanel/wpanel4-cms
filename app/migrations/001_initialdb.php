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
 * Migration class.
 *
 * This class creates a initial database to WpanelCms.
 *
 * @package     WpanelCms
 * @subpackage  Migrations
 * @category    Migrations
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        https://wpanelcms.com.br
 * @version     0.0.1
 */
class Migration_Initialdb extends CI_Migration
{

	public function up()
	{

		/* albuns */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("user_id int(11) DEFAULT NULL");
		$this->dbforge->add_field("titulo varchar(200) NOT NULL");
		$this->dbforge->add_field("descricao mediumtext DEFAULT NULL");
		$this->dbforge->add_field("capa varchar(200) DEFAULT NULL");
		$this->dbforge->add_field("created datetime DEFAULT NULL");
		$this->dbforge->add_field("updated datetime DEFAULT NULL");
		$this->dbforge->add_field("status int(11) NOT NULL");

		$this->dbforge->create_table('albuns', true);

		/* banners */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("user_id int(11) DEFAULT NULL");
		$this->dbforge->add_field("title varchar(100) NOT NULL");
		$this->dbforge->add_field("position varchar(20) DEFAULT NULL");
		$this->dbforge->add_field("sequence int(11) DEFAULT NULL");
		$this->dbforge->add_field("type varchar(20) DEFAULT NULL");
		$this->dbforge->add_field("content mediumtext DEFAULT NULL");
		$this->dbforge->add_field("created datetime DEFAULT NULL");
		$this->dbforge->add_field("updated datetime DEFAULT NULL");
		$this->dbforge->add_field("status int(11) NOT NULL");

		$this->dbforge->create_table('banners', true);

		/* captcha */

		$this->dbforge->add_field(array('captcha_id' => array('type'=>'INT','constraint'=>11,'unsigned'=>TRUE,'null'=>FALSE,'auto_increment'=>TRUE)));
		$this->dbforge->add_field(array('captcha_time' => array('type'=>'INT','constraint'=>10,'unsigned'=>TRUE,'null'=>FALSE)));
		$this->dbforge->add_field(array('ip_address' => array('type' =>'varchar','constraint'=>'45','null'=>FALSE)));
		$this->dbforge->add_field(array('word' => array('type'=>'varchar','constraint'=>'20','null'=>FALSE)));


		$this->dbforge->add_key('captcha_id', TRUE);
		$this->dbforge->add_key('word');
		$this->dbforge->create_table('captcha', true);

		/* categories */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("title varchar(45) NOT NULL");
		$this->dbforge->add_field("link varchar(100) DEFAULT NULL");
		$this->dbforge->add_field("description text");
		$this->dbforge->add_field("category_id int(11) DEFAULT NULL");
		$this->dbforge->add_field("view varchar(45) DEFAULT 'Lista'");

		$this->dbforge->create_table('categories', true);

		/* fotos */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("album_id int(11) DEFAULT NULL");
		$this->dbforge->add_field("descricao varchar(255) DEFAULT NULL");
		$this->dbforge->add_field("filename varchar(200) DEFAULT NULL");
		$this->dbforge->add_field("sequence int(11) DEFAULT NULL");
		$this->dbforge->add_field("created datetime DEFAULT NULL");
		$this->dbforge->add_field("updated datetime DEFAULT NULL");
		$this->dbforge->add_field("status int(11) DEFAULT NULL");

		$this->dbforge->create_table('fotos', true);

		/* menus */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("user_id int(11) NOT NULL");
		$this->dbforge->add_field("nome varchar(100) DEFAULT NULL");
		$this->dbforge->add_field("slug varchar(200) DEFAULT NULL");
		$this->dbforge->add_field("posicao varchar(45) DEFAULT NULL");
		$this->dbforge->add_field("estilo varchar(45) DEFAULT NULL");
		$this->dbforge->add_field("created datetime DEFAULT NULL");
		$this->dbforge->add_field("updated datetime DEFAULT NULL");

		$this->dbforge->create_table('menus', true);

		/* menu_itens */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("menu_id int(11) NOT NULL");
		$this->dbforge->add_field("label varchar(200) DEFAULT NULL");
		$this->dbforge->add_field("tipo varchar(45) DEFAULT NULL");
		$this->dbforge->add_field("href text");
		$this->dbforge->add_field("slug varchar(200) DEFAULT NULL");
		$this->dbforge->add_field("ordem int(11) DEFAULT NULL");
		$this->dbforge->add_field("created datetime DEFAULT NULL");
		$this->dbforge->add_field("updated datetime DEFAULT NULL");

		$this->dbforge->create_table('menu_itens', true);

		/* newsletter_email */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("nome varchar(45) DEFAULT NULL");
		$this->dbforge->add_field("email varchar(100) DEFAULT NULL");
		$this->dbforge->add_field("created datetime DEFAULT NULL");

		$this->dbforge->create_table('newsletter_email', true);

		/* posts */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("title varchar(200) NOT NULL");
		$this->dbforge->add_field("description varchar(200) DEFAULT NULL");
		$this->dbforge->add_field("link varchar(200) NOT NULL");
		$this->dbforge->add_field("content text NOT NULL");
		$this->dbforge->add_field("created datetime DEFAULT NULL");
		$this->dbforge->add_field("updated datetime DEFAULT NULL");
		$this->dbforge->add_field("image varchar(200) DEFAULT NULL");
		$this->dbforge->add_field("tags text");
		$this->dbforge->add_field("status varchar(20) DEFAULT NULL");
		$this->dbforge->add_field("user_id int(11) NOT NULL");
		$this->dbforge->add_field("page tinyint(1) DEFAULT '0'");

		$this->dbforge->create_table('posts', true);

		/* posts_categories */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("post_id int(11) NOT NULL");
		$this->dbforge->add_field("category_id int(11) NOT NULL");

		$this->dbforge->create_table('posts_categories', true);

		/* videos */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field(array('user_id' => array('type' => 'int(11)')));
		$this->dbforge->add_field("titulo varchar(255) NOT NULL");
		$this->dbforge->add_field("descricao text NOT NULL");
		$this->dbforge->add_field("link varchar(200) NOT NULL");
		$this->dbforge->add_field("sequence int(11) DEFAULT NULL");
		$this->dbforge->add_field("created datetime NOT NULL");
		$this->dbforge->add_field("updated datetime NOT NULL");
		$this->dbforge->add_field("status tinyint(1) NOT NULL");


		$this->dbforge->create_table('videos', true);

		/* users */

		$this->dbforge->add_field("id");
		$this->dbforge->add_field("name varchar(100) NOT NULL");
		$this->dbforge->add_field("image varchar(255) DEFAULT NULL");
		$this->dbforge->add_field("skin varchar(40) DEFAULT NULL");
		$this->dbforge->add_field("email varchar(100) NOT NULL");
		$this->dbforge->add_field("username varchar(100) NOT NULL");
		$this->dbforge->add_field("password varchar(150) NOT NULL");
		$this->dbforge->add_field("role varchar(20) DEFAULT NULL");
		$this->dbforge->add_field(array('permissions' => array('type' => 'LONGTEXT', 'after'=>'role')));
		$this->dbforge->add_field("created datetime DEFAULT NULL");
		$this->dbforge->add_field("updated datetime DEFAULT NULL");
		$this->dbforge->add_field("status varchar(20) DEFAULT NULL");

		$this->dbforge->create_table('users', true);

		/* initial data */

		$this->db->query("INSERT INTO `categories` (`id`, `title`, `link`, `description`, `category_id`, `view`) VALUES (1, 'Categoria de exemplo', 'Categoria-de-exemplo', '', 0, 'list'), (2, 'Sub-categoria de exemplo', 'Sub-categoria-de-exemplo', '', 1, 'list');");
		$this->db->query("INSERT INTO `menus` (`id`, `user_id`, `nome`, `slug`, `posicao`, `estilo`, `created`, `updated`) VALUES (1, 1, 'Menu principal', 'menu-principal', 'topo', 'lista', '2015-06-01 11:30:39', '2015-06-01 11:37:01');");
		$this->db->query("INSERT INTO `menu_itens` (`id`, `menu_id`, `label`, `tipo`, `href`, `slug`, `ordem`, `created`, `updated`) VALUES (1, 1, 'Início', 'funcional', 'home', '', 1, '2015-06-01 13:08:00', '2015-06-02 16:02:10'), (2, 1, 'Fotos', 'funcional', 'albuns', '', 3, '2015-06-01 18:03:37', '2015-06-02 15:55:28'), (3, 1, 'Sobre', 'post', 'sobre', '', 5, '2015-06-01 22:40:27', '2015-06-02 17:14:47'), (4, 1, 'Postagens', 'posts', '1', '', 2, '2015-06-02 14:08:34', '2015-06-02 17:14:13'), (5, 1, 'Fale conosco', 'funcional', 'contato', '', 6, '2015-06-02 17:15:01', '2015-06-02 17:15:01'), (6, 1, 'Vídeos', 'funcional', 'videos', '', 4, '2015-06-02 17:14:36', '2015-06-02 17:14:36');");
		$this->db->query("INSERT INTO `posts` (`id`, `title`, `description`, `link`, `content`, `created`, `updated`, `image`, `tags`, `status`, `user_id`, `page`) VALUES (1, 'Página inicial', 'Página inicial de exemplo do WPanel', 'pagina-inicial', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n', '2014-11-09 23:17:53', '2014-12-18 20:09:59', '0', 'wpanel, bem vindo, exemplo', '1', 1, 1), (2, 'Sobre', 'Um exemplo de página específica para o menu.', 'sobre', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', '2014-11-09 23:29:16', '2014-11-09 23:29:16', '0', 'exemplo, pagina, sobre', '1', 1, 1), (3, 'Postagem de exemplo', 'Exemplo de postagem', 'postagem-de-exemplo', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', '2014-11-08 23:46:38', '2014-11-10 00:04:22', '9dabbecde6cea5563d45809bfa5f1697.jpg', 'demo, post, wpanel', '1', 1, 0), (4, 'Segunda postagem de exemplo', 'Postagem de exemplo do Wpanel', 'segunda-postagem-de-exemplo', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', '2014-11-09 23:47:15', '2014-11-10 01:12:01', 'c691918e299d4d793a0838fba6738a6d.jpg', 'demo, post, exemplo, wpanel', '1', 1, 0);");
		$this->db->query("INSERT INTO `posts_categories` (`id`, `post_id`, `category_id`) VALUES (1, 3, 1), (2, 4, 2);");
		$this->db->query("INSERT INTO `videos` (`id`, `user_id`, `titulo`, `descricao`, `link`, `created`, `updated`, `status`) VALUES (1, 1, 'Apresentação do WPanel CMS', 'Vídeo de apresentação do WPanel CMS',  'p95Nflq_wqc',  '2015-08-12 20:04:50',  '2015-08-12 20:04:50',  1), (2, 1, 'Configuração do WPanel', 'Veja como fazer a configuração básica do site pelo WPanel.', '1Dqnsva8APY',  '2015-08-12 20:11:20',  '2015-08-12 20:11:20',  1), (3, 1, 'Cadastro de usuários', 'Vídeo sobre o gerenciamento básico de usuários no WPanel.',  'GquE1EVNKoc',  '2015-08-12 20:11:54',  '2015-08-12 20:11:54',  1), (4, 1, 'Páginas e Postagens',  'Vídeo apresentando o gerenciamento de páginas e postagens no WPanel CMS.', 'PDArEJR3ny4',  '2015-08-12 20:13:01',  '2015-08-12 20:13:01',  1), (5, 1, 'Banners',  'Vídeo sobre o gerenciamento de banners no WPanel.',  'gY46fXNbmmg',  '2015-08-12 20:14:07',  '2015-08-12 20:14:07',  1), (6, 1, 'Álbum de fotos', 'Este vídeo mostra como gerenciar álbuns de fotos no WPanel CMS.',  'GVUIvYW9Z_c',  '2015-08-12 20:14:47',  '2015-08-12 20:14:47',  1); ");
		$this->db->query("INSERT INTO `banners` (`id`, `title`, `position`, `sequence`, `type`, `content`, `created`, `updated`, `status`, `user_id`) VALUES (1, 'Banner de exemplo #1', 'slide', 1, NULL, '4742fdb5443d36068de2ccd7181524e4.jpg', '2014-11-10 12:00:00', '2014-11-10 12:00:00', '1', 1), (2, 'Banner de exemplo #2', 'slide', 2, NULL, 'baf049832810506469b65f68bffb8910.jpg', '2014-11-10 12:00:00', '2014-11-10 12:00:00', '1', 1), (3, 'Banner de exemplo #2', 'slide', 2, NULL, 'f319e687ef3043e75bea52acf6032d8c.jpg', '2014-11-10 12:00:00', '2014-11-10 12:00:00', '1', 1); ");

	}

	public function down()
	{
		$this->dbforge->drop_table('albuns', true);
		$this->dbforge->drop_table('banners', true);
		$this->dbforge->drop_table('captcha', true);
		$this->dbforge->drop_table('categories', true);
		$this->dbforge->drop_table('fotos', true);
		$this->dbforge->drop_table('menus', true);
		$this->dbforge->drop_table('menu_itens', true);
		$this->dbforge->drop_table('newsletter_email', true);
		$this->dbforge->drop_table('posts', true);
		$this->dbforge->drop_table('posts_categories', true);
		$this->dbforge->drop_table('videos', true);
		$this->dbforge->drop_table('users', true);
	}
}
