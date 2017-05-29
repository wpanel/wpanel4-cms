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
 * This class updates a initial database to WpanelCms.
 *
 * @package     WpanelCms
 * @subpackage  Migrations
 * @category    Migrations
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        https://wpanelcms.com.br
 * @version     0.0.1
 */
class Migration_newauth extends CI_Migration
{
	public function up()
	{
		// Renomeia a tabela 'users' para fins de recuperação.
		$this->dbforge->rename_table('users', 'users_bkp', TRUE);

		// Cria uma nova tabela 'accounts' com a nova estrutura.
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'email' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => FALSE
			),
			'password' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE
			),
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => FALSE,
			),
			'extra_data' => array(
				'type' => 'TEXT',
				'null' => FALSE,
			),
			'ip_address' => array(
				'type' => 'varchar',
				'constraint' => 15,
				'default' => '0.0.0.0'
			),
			'activated' => array(
				'type' => 'datetime',
				'null' => TRUE
			),
			'created' => array(
				'type' => 'datetime',
				'null' => TRUE,
			),
			'updated' => array(
				'type' => 'datetime',
				'null' => TRUE,
			),
			'status' => array(
				'type' => 'int',
				'null' => FALSE,
				'default' => '0'
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('accounts', true);
		$fields = NULL;

		// Cria a tabela 'modules'
		$fields = array(
			'id' => array(
    			'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
			),
			'name' => array(
    			'type' => 'varchar',
    			'constraint' => 60,
    			'null' => FALSE
			),
			'icon' => array(
    			'type' => 'varchar',
    			'constraint' => 100,
    			'null' => TRUE
			),
			'show_in_menu' => array(
    			'type' => 'int',
    			'constraint' => 11,
    			'null' => TRUE
			),
			'order' => array(
    			'type' => 'int',
    			'constraint' => 2,
    			'null' => TRUE
			),
			'created' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        ),
	        'updated' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        )
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('modules', TRUE);
		$fields = NULL;

		// Cria a tabela 'modules_actions'
		$fields = array(
			'id' => array(
    			'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
			),
			'module_id' => array(
	        	'type' => 'INT',
	        	'null' => FALSE
	        ),
	        'description' => array(
    			'type' => 'varchar',
    			'constraint' => 255,
    			'null' => FALSE
			),
			'link' => array(
    			'type' => 'varchar',
    			'constraint' => 255,
    			'null' => FALSE
			),
			'whitelist' => array(
				'type' => 'int',
				'constraint' => 11,
				'default' => '0'
			),

			'created' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        ),
	        'updated' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        )
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('module_id');
		$this->dbforge->create_table('modules_actions', true);
		$fields = NULL;

		// Cria a tabela permissions
		$fields = array(
			'id' => array(
    			'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
			),
			'module_id' => array(
	        	'type' => 'INT',
	        	'null' => FALSE
	        ),
	        'module_action_id' => array(
	        	'type' => 'INT',
	        	'null' => FALSE
	        ),
	        'account_id' => array(
	        	'type' => 'INT',
	        	'null' => FALSE
	        ),
			'created' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        ),
	        'updated' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        )
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('module_id');
		$this->dbforge->add_key('module_action_id');
		$this->dbforge->add_key('account_id');
		$this->dbforge->create_table('permissions', true);
		$fields = NULL;

		// Cria a tabela log_access
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'user_id' => array(
				'type' => 'INT',
				'null' => FALSE
			),
			'ip_address' => array(
				'type' => 'varchar',
				'constraint' => 15,
				'null' => FALSE,
				'default' => '0.0.0.0'
			),
			'created' => array(
				'type' => 'datetime',
				'null' => TRUE,
			)
			// Nesta tabela não teremos a coluna 'created' pois só vai ter o registro sem alteração.
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('module_id');
		$this->dbforge->create_table('log_access', true);
		$fields = NULL;

		// Cria a tabela ip_attempts
		$fields = array(
			'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
	        ),
	        'ip_address' => array(
	        	'type' => 'varchar',
	        	'constraint' => 15,
	        	'null' => FALSE,
	        	'default' => '0.0.0.0'
        	),
        	'last_failed_attempt' => array(
        		'type' => 'datetime',
        		'null' => FALSE,
    		),
    		'number_of_attempts' => array(
    			'type' => 'int',
    			'constraint' => 11,
    			'null' => FALSE
			),
			'created' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        ),
	        'updated' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        )
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('number_of_attempts');
		$this->dbforge->create_table('ip_attempts', true);
		$fields = NULL;

		// Cria a tabela ip_banned
		$fields = array(
			'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
	        ),
	        'ip_address' => array(
	        	'type' => 'varchar',
	        	'constraint' => 15,
	        	'null' => FALSE,
	        	'default' => '0.0.0.0'
        	),
			'created' => array(
	        	'type' => 'datetime',
	        	'null' => TRUE,
	        )
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('ip_address');
		$this->dbforge->create_table('ip_banned', true);
		$fields = NULL;

		// Adiciona os módulos iniciais.
		$this->db->query("INSERT INTO `modules` (`id`, `name`, `icon`, `show_in_menu`, `order`, `created`, `updated`) VALUES
			(1,	'Postagens',	'',	1,	0,	'2016-10-08 18:25:03',	'2016-10-08 18:25:03'),
			(2,	'Páginas',	'',	1,	0,	'2016-10-08 18:28:50',	'2016-10-08 18:28:50'),
			(3,	'Eventos',	'',	1,	0,	'2016-10-08 18:30:04',	'2016-10-08 18:30:09'),
			(4,	'Banners',	'',	1,	0,	'2016-10-08 18:31:11',	'2016-10-08 18:31:11'),
			(5,	'Galerias',	'',	1,	0,	'2016-10-08 18:32:32',	'2016-10-08 18:44:17'),
			(6,	'Vídeos',	'',	1,	0,	'2016-10-08 18:43:05',	'2016-10-08 18:43:05'),
			(7,	'Gerenciador de Menu',	'',	1,	0,	'2016-10-08 18:44:32',	'2016-10-08 18:44:32'),
			(8,	'Newsletters',	'',	1,	0,	'2016-10-08 18:47:42',	'2016-10-08 18:47:42'),
			(9,	'Contas de usuário',	'',	1,	0,	'2016-10-08 18:48:13',	'2016-10-08 18:48:13'),
			(10,	'Configurações',	'',	1,	0,	'2016-10-08 18:51:28',	'2016-10-08 18:51:28');");
		
		// Adiciona as ações dos módulos iniciais.
		$this->db->query("INSERT INTO `modules_actions` (`id`, `module_id`, `description`, `link`, `whitelist`, `created`, `updated`) VALUES
			(1,	1,	'Listar postagens',	'admin/posts',	0,	'2016-10-08 18:25:23',	'2016-10-08 18:25:23'),
			(2,	1,	'Adicionar postaagem',	'admin/posts/add',	0,	'2016-10-08 18:25:40',	'2016-10-08 18:25:40'),
			(3,	1,	'Alterar postagem',	'admin/posts/edit/*',	0,	'2016-10-08 18:25:57',	'2016-10-08 18:25:57'),
			(4,	1,	'Excluir postagem',	'admin/posts/delete/*',	0,	'2016-10-08 18:26:14',	'2016-10-08 18:26:14'),
			(5,	1,	'Listar categorias de postagens',	'admin/categorias',	0,	'2016-10-08 18:26:45',	'2016-10-08 18:26:45'),
			(6,	1,	'Adicionar categoria de postagens',	'admin/categorias/add',	0,	'2016-10-08 18:27:03',	'2016-10-08 18:27:03'),
			(7,	1,	'Alterar categorias de postagens',	'admin/categorias/edit/*',	0,	'2016-10-08 18:27:17',	'2016-10-08 18:27:17'),
			(8,	1,	'Excluir categorias de postagens',	'admin/categorias/delete/*',	0,	'2016-10-08 18:27:31',	'2016-10-08 18:27:31'),
			(9,	2,	'Listar páginas',	'admin/pages',	0,	'2016-10-08 18:28:59',	'2016-10-08 18:28:59'),
			(10,	2,	'Adicionar páginas',	'admin/pages/add',	0,	'2016-10-08 18:29:12',	'2016-10-08 18:29:12'),
			(11,	2,	'Alterar páginas',	'admin/pages/edit/*',	0,	'2016-10-08 18:29:23',	'2016-10-08 18:29:23'),
			(12,	2,	'Excluir páginas',	'admin/pages//delete/*',	0,	'2016-10-08 18:29:35',	'2016-10-08 18:29:35'),
			(13,	3,	'Listar eventos',	'admin/agendas',	0,	'2016-10-08 18:30:20',	'2016-10-08 18:30:20'),
			(14,	3,	'Adicionar eventos',	'admin/agendas/add',	0,	'2016-10-08 18:30:28',	'2016-10-08 18:30:28'),
			(15,	3,	'Alterar eventos',	'admin/agendas/edit/*',	0,	'2016-10-08 18:30:39',	'2016-10-08 18:30:39'),
			(16,	3,	'Excluir eventos',	'admin/agendas/delete/*',	0,	'2016-10-08 18:30:49',	'2016-10-08 18:30:49'),
			(17,	4,	'Listar banners',	'admin/banners',	0,	'2016-10-08 18:31:23',	'2016-10-08 18:31:23'),
			(18,	4,	'Adicionar banners',	'admin/banners/add',	0,	'2016-10-08 18:31:39',	'2016-10-08 18:31:39'),
			(19,	4,	'Alterar banners',	'admin/banners/edit/*',	0,	'2016-10-08 18:31:49',	'2016-10-08 18:31:49'),
			(20,	4,	'Excluir banners',	'admin/banners/delete/*',	0,	'2016-10-08 18:31:58',	'2016-10-08 18:31:58'),
			(21,	5,	'Listar galerias',	'admin/albuns',	0,	'2016-10-08 18:32:43',	'2016-10-08 18:32:43'),
			(22,	5,	'Adicionar galerias',	'admin/albuns/add',	0,	'2016-10-08 18:32:58',	'2016-10-08 18:32:58'),
			(23,	5,	'Alterar galerias',	'admin/albuns/edit/*',	0,	'2016-10-08 18:37:15',	'2016-10-08 18:37:15'),
			(24,	5,	'Excluir galerias',	'admin/albuns/delete/*',	0,	'2016-10-08 18:37:34',	'2016-10-08 18:37:34'),
			(25,	5,	'Listar fotos da galeria',	'admin/fotos/index/*',	0,	'2016-10-08 18:40:11',	'2016-10-08 18:40:11'),
			(26,	5,	'Adiciona foto na galeria individualmente',	'admin/fotos/add/*',	0,	'2016-10-08 18:40:53',	'2016-10-08 18:40:53'),
			(27,	5,	'Adiciona foto na galeria em massa',	'admin/fotos/addmass/*',	0,	'2016-10-08 18:41:17',	'2016-10-08 18:41:17'),
			(28,	5,	'Alterar fotos da galeria',	'admin/fotos/edit/*',	0,	'2016-10-08 18:42:00',	'2016-10-08 18:42:00'),
			(29,	5,	'Apagar foto da galeria',	'admin/fotos/delete/*',	0,	'2016-10-08 18:42:25',	'2016-10-08 18:42:25'),
			(30,	6,	'Listar vídeos',	'admin/videos',	0,	'2016-10-08 18:43:13',	'2016-10-08 18:43:13'),
			(31,	6,	'Adicionar vídeo',	'admin/videos/add',	0,	'2016-10-08 18:43:21',	'2016-10-08 18:43:21'),
			(32,	6,	'Alterar vídeo',	'admin/videos/edit/*',	0,	'2016-10-08 18:43:35',	'2016-10-08 18:43:35'),
			(33,	6,	'Apagar vídeo',	'admin/videos/delete/*',	0,	'2016-10-08 18:43:47',	'2016-10-08 18:43:47'),
			(34,	7,	'Listar menus',	'admin/menus',	0,	'2016-10-08 18:44:50',	'2016-10-08 18:45:16'),
			(35,	7,	'Adicionar menus',	'admin/menus/add',	0,	'2016-10-08 18:45:26',	'2016-10-08 18:45:26'),
			(36,	7,	'Alterar menu',	'admin/menus/edit/*',	0,	'2016-10-08 18:45:41',	'2016-10-08 18:45:41'),
			(37,	7,	'Apagar menu',	'admin/menus/delete/*',	0,	'2016-10-08 18:45:53',	'2016-10-08 18:45:53'),
			(38,	7,	'Adicionar item de menu',	'admin/menuitens/add/*',	0,	'2016-10-08 18:46:26',	'2016-10-08 18:46:26'),
			(39,	7,	'Alterar item de menu',	'admin/menuitens/edit/*',	0,	'2016-10-08 18:46:45',	'2016-10-08 18:46:45'),
			(40,	7,	'Apagar item de menu',	'admin/menuitens/delete/*',	0,	'2016-10-08 18:47:01',	'2016-10-08 18:47:01'),
			(41,	8,	'Listar emails',	'admin/newsletters',	0,	'2016-10-08 18:47:50',	'2016-10-08 18:47:50'),
			(42,	9,	'Listar usuários',	'admin/accounts',	0,	'2016-10-08 18:48:21',	'2016-10-08 18:48:21'),
			(43,	9,	'Adicionar usuário',	'admin/accounts/add',	0,	'2016-10-08 18:48:35',	'2016-10-08 18:48:35'),
			(44,	9,	'Alterar usuários',	'admin/accounts/edit/*',	0,	'2016-10-08 18:48:49',	'2016-10-08 18:48:49'),
			(45,	9,	'Apagar usuário',	'admin/accounts/delete/*',	0,	'2016-10-08 18:49:10',	'2016-10-08 18:49:10'),
			(46,	9,	'Alterar senha de usuários',	'admin/accounts/changepassword/*',	0,	'2016-10-08 18:49:57',	'2016-10-08 18:49:57'),
			(47,	9,	'Listar IP´s manidos',	'admin/ipbanneds',	0,	'2016-10-08 18:50:19',	'2016-10-08 18:50:19'),
			(48,	9,	'Banir um IP',	'admin/ipbanneds/add',	0,	'2016-10-08 18:50:32',	'2016-10-08 18:50:32'),
			(49,	9,	'Apagar um IP banido',	'admin/ipbanneds/delete/*',	0,	'2016-10-08 18:51:04',	'2016-10-08 18:51:04'),
			(50,	10,	'Visualizar configurações',	'admin/configuracoes',	0,	'2016-10-08 18:52:09',	'2016-10-08 18:52:09'),
			(51,	10,	'Salvar configurações',	'admin/configuracoes/index',	0,	'2016-10-08 18:52:18',	'2016-10-08 18:52:18');");

	}

	public function down()
	{
		// Exclui a tabela 'users' nova.
		$this->dbforge->drop_table('accounts');
		// Restaura a tabela 'users' antiga.
		$this->dbforge->rename_table('users_bkp', 'users');
		// Exclui a tabela ip_attempts
		$this->dbforge->drop_table('ip_attempts');
		// Exclui a tabela modules.
		$this->dbforge->drop_table('modules');
		// Exclui a tabela modules_actions.
		$this->dbforge->drop_table('modules_actions');
		// Exclui a tabela log_access.
		$this->dbforge->drop_table('log_access');
	}
}