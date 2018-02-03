<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration class.
 *
 * This class creates a initial database to WpanelCms.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 */
class Migration_Initialdb extends CI_Migration
{

    /**
     * Common fields to the tables.
     * @var mixed 
     */
    protected $common_fields = array(
        'created_on' => array(
            'type' => 'datetime',
            'null' => TRUE,
        ),
        'modified_on' => array(
            'type' => 'datetime',
            'null' => TRUE,
        ),
        'created_by' => array(
            'type' => 'int',
            'constraint' => 11,
            'default' => 0
        ),
        'modified_by' => array(
            'type' => 'int',
            'constraint' => 11,
            'default' => 0
        ),
        'deleted' => array(
            'type' => 'int',
            'constraint' => 11,
            'default' => 0
        ),
        'deleted_by' => array(
            'type' => 'int',
            'constraint' => 11,
            'default' => 0
        ),
    );

    /**
     * Account table fields.
     * @var mixed 
     */
    protected $accounts_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
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
            'type' => 'varchar',
            'constraint' => '20',
            'null' => FALSE,
        ),
        'extra_data' => array(
            'type' => 'text',
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
        'status' => array(
            'type' => 'int',
            'null' => FALSE,
            'default' => '0'
        ),
        'token' => array(
            'type' => 'VARCHAR',
            'constraint' => 255,
            'NULL' => 'FALSE'
        ),
        'token_by' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
            'NULL' => 'FALSE'
        )
    );

    /**
     * Album table fields.
     * @var mixed 
     */
    protected $albuns_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'titulo' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => FALSE
        ),
        'descricao' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'tags' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'capa' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => TRUE
        ),
        'status' => array(
            'type' => 'int',
            'constraint' => 1,
            'null' => TRUE
        ),
    );

    /**
     * Banners table fields.
     * @var mixed 
     */
    protected $banners_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'title' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => FALSE
        ),
        'position' => array(
            'type' => 'varchar',
            'constraint' => 20,
            'null' => TRUE
        ),
        'sequence' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => TRUE
        ),
        'type' => array(
            'type' => 'varchar',
            'constraint' => 20,
            'null' => TRUE
        ),
        'content' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'status' => array(
            'type' => 'int',
            'constraint' => 1,
            'null' => TRUE
        ),
    );

    /**
     * Captcha table fields.
     * @var mixed 
     */
    protected $captcha_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'captcha_time' => array(
            'type' => 'int',
            'constraint' => 10,
            'null' => FALSE
        ),
        'ip_address' => array(
            'type' => 'varchar',
            'constraint' => 45,
            'null' => FALSE
        ),
        'word' => array(
            'type' => 'varchar',
            'constraint' => 20,
            'null' => FALSE
        ),
    );

    /**
     * Categories table fields.
     * @var mixed 
     */
    protected $categories_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'title' => array(
            'type' => 'varchar',
            'constraint' => 45,
            'null' => FALSE
        ),
        'link' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => TRUE
        ),
        'description' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'category_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => TRUE
        ),
        'view' => array(
            'type' => 'varchar',
            'constraint' => 45,
            'null' => TRUE
        ),
    );

    /**
     * Fotos table fields.
     * @var mixed 
     */
    protected $fotos_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'album_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => FALSE
        ),
        'descricao' => array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => TRUE
        ),
        'filename' => array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => TRUE
        ),
        'sequence' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => TRUE
        ),
        'status' => array(
            'type' => 'int',
            'constraint' => 1,
            'null' => TRUE
        ),
    );

    /**
     * IP attempts table fields.
     * @var mixed
     */
    protected $ipattempts_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'ip_address' => array(
            'type' => 'varchar',
            'constraint' => 15,
            'null' => FALSE
        ),
        'last_failed_attempt' => array(
            'type' => 'datetime',
            'null' => FALSE
        ),
        'number_of_attempts' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => FALSE
        ),
    );

    /**
     * IP Banned table fields.
     * @var mixed 
     */
    protected $ipbanned_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'ip_address' => array(
            'type' => 'varchar',
            'constraint' => 15,
            'null' => FALSE
        )
    );
    
    /**
     * IP Allowed table fields.
     * @var mixed 
     */
    protected $ipallowed_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'description' => array(
            'type' => 'varchar',
            'constraint' => 120,
            'null' => TRUE
        ),
        'ip_address' => array(
            'type' => 'varchar',
            'constraint' => 15,
            'null' => FALSE
        )
    );

    /**
     * Log access table fields.
     * @var mixed 
     */
    protected $logaccess_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'ip_address' => array(
            'type' => 'varchar',
            'constraint' => 15,
            'null' => FALSE
        )
    );

    /**
     * Menu itens table fields.
     * @var mixed 
     */
    protected $menuitens_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'menu_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => FALSE,
        ),
        'label' => array(
            'type' => 'varchar',
            'constraint' => 100,
            'null' => TRUE
        ),
        'tipo' => array(
            'type' => 'varchar',
            'constraint' => 45,
            'null' => TRUE
        ),
        'href' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'slug' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => TRUE
        ),
        'ordem' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => TRUE
        ),
    );

    /**
     * Menus table fields.
     * @var mixed 
     */
    protected $menus_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'nome' => array(
            'type' => 'varchar',
            'constraint' => 100,
            'null' => TRUE
        ),
        'slug' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => TRUE
        ),
        'posicao' => array(
            'type' => 'varchar',
            'constraint' => 45,
            'null' => TRUE
        ),
        'estilo' => array(
            'type' => 'varchar',
            'constraint' => 45,
            'null' => TRUE
        ),
    );

    /**
     * Migration table fields.
     * @var mixed 
     */
    protected $migration_fields = array(
        'version' => array(
            'type' => 'bigint',
            'constraint' => 20,
            'null' => FALSE
        )
    );

    /**
     * Modules table fields.
     * @var mixed 
     */
    protected $modules_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
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
            'constraint' => 11,
            'null' => TRUE
        ),
    );

    /**
     * Modules actions table fields.
     * @var mixed 
     */
    protected $mod_actions_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'module_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => FALSE,
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
            'null' => FALSE
        ),
    );

    /**
     * Newsletter emails table fields.
     * @var mixed 
     */
    protected $newsletter_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'nome' => array(
            'type' => 'varchar',
            'constraint' => 60,
            'null' => TRUE
        ),
        'email' => array(
            'type' => 'varchar',
            'constraint' => 100,
            'null' => TRUE
        ),
        'ipaddress' => array(
            'type' => 'varchar',
            'constraint' => 20,
            'null' => TRUE
        ),
    );

    /**
     * Permissions table fields.
     * @var mixed 
     */
    protected $permissions_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'module_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => FALSE,
        ),
        'module_action_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => FALSE,
        ),
        'account_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => FALSE,
        ),
    );

    /**
     * Post table fields.
     * @var mixed 
     */
    protected $posts_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'title' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => FALSE
        ),
        'description' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'link' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => FALSE
        ),
        'content' => array(
            'type' => 'text',
            'null' => FALSE
        ),
        'image' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => TRUE
        ),
        'tags' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'page' => array(
            'type' => 'int',
            'constraint' => 1,
            'null' => TRUE
        ),
        'status' => array(
            'type' => 'int',
            'constraint' => 1,
            'null' => TRUE
        ),
    );

    /**
     * Post categories table fields.
     * @var mixed 
     */
    protected $post_cat_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'post_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => TRUE,
        ),
        'category_id' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => TRUE,
        ),
    );
    
    /**
     * NewsNotifications table fields.
     * @var mixed 
     */
    protected $newsnotifications_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'title' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => FALSE
        ),
        'description' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'url' => array(
            'type' => 'varchar',
            'constraint' => 255,
            'null' => FALSE
        ),
        'status' => array(
            'type' => 'int',
            'constraint' => 1,
            'null' => TRUE
        ),
    );

    /**
     * Video table fields.
     * @var mixed 
     */
    protected $videos_fields = array(
        'id' => array(
            'type' => 'int',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'titulo' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => FALSE
        ),
        'descricao' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'tags' => array(
            'type' => 'text',
            'null' => TRUE
        ),
        'link' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => FALSE
        ),
        'sequence' => array(
            'type' => 'int',
            'constraint' => 11,
            'null' => TRUE
        ),
        'status' => array(
            'type' => 'int',
            'constraint' => 1,
            'null' => FALSE
        ),
    );

    /**
     * Generate the tables into the database.
     */
    public function up()
    {

        /**
         * Generate accounts table.
         */
        $this->dbforge->add_field($this->accounts_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('accounts', true);

        /**
         * Generate albuns table.
         */
        $this->dbforge->add_field($this->albuns_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('albuns', true);

        /**
         * Generate banners table.
         */
        $this->dbforge->add_field($this->banners_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('banners', true);

        /**
         * Generate captcha table.
         */
        $this->dbforge->add_field($this->captcha_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('captcha', true);

        /**
         * Generate categories table.
         */
        $this->dbforge->add_field($this->categories_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('categories', true);

        /**
         * Generate fotos table.
         */
        $this->dbforge->add_field($this->fotos_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('fotos', true);

        /**
         * Generate menus table.
         */
        $this->dbforge->add_field($this->menus_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('menus', true);

        /**
         * Generate menu_itens table.
         */
        $this->dbforge->add_field($this->menuitens_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('menu_id');
        $this->dbforge->create_table('menu_itens', true);

        /**
         * Generate newsletter_email table.
         */
        $this->dbforge->add_field($this->newsletter_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('newsletter_email', true);

        /**
         * Generate posts table.
         */
        $this->dbforge->add_field($this->posts_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('posts', true);

        /**
         * Generate post_categories table.
         */
        $this->dbforge->add_field($this->post_cat_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('posts_categories', true);

        /**
         * Generate NewsNotifications table.
         */
        $this->dbforge->add_field($this->newsnotifications_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('newsnotifications', true);
        
        /**
         * Generate videos table.
         */
        $this->dbforge->add_field($this->videos_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('videos', true);

        /**
         * Generate modules table.
         */
        $this->dbforge->add_field($this->modules_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('modules', true);

        /**
         * Generate modules_actions table.
         */
        $this->dbforge->add_field($this->mod_actions_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('modules_actions', true);

        /**
         * Generate perissions table.
         */
        $this->dbforge->add_field($this->permissions_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('permissions', true);

        /**
         * Generate log_access table.
         */
        $this->dbforge->add_field($this->logaccess_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('log_access', true);

        /**
         * Generate ip_attempts table.
         */
        $this->dbforge->add_field($this->ipattempts_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ip_attempts', true);

        /**
         * Generate ip_banned table.
         */
        $this->dbforge->add_field($this->ipbanned_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ip_banned', true);
        
        /**
         * Generate ip_allowed table.
         */
        $this->dbforge->add_field($this->ipallowed_fields);
        $this->dbforge->add_field($this->common_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ip_alloweds', true);

        /**
         * Seed the initial data into the database.
         */
        $this->db->query("INSERT INTO `modules` VALUES ('1', 'Postagens', '', '1', '0', '2016-10-08 18:25:03', '2016-10-08 18:25:03', '0', '0', '0', '0'), ('2', 'Páginas', '', '1', '0', '2016-10-08 18:28:50', '2016-10-08 18:28:50', '0', '0', '0', '0'), ('3', 'Eventos', '', '1', '0', '2016-10-08 18:30:04', '2016-10-08 18:30:09', '0', '0', '0', '0'), ('4', 'Banners', '', '1', '0', '2016-10-08 18:31:11', '2016-10-08 18:31:11', '0', '0', '0', '0'), ('5', 'Galerias', '', '1', '0', '2016-10-08 18:32:32', '2016-10-08 18:44:17', '0', '0', '0', '0'), ('6', 'Vídeos', '', '1', '0', '2016-10-08 18:43:05', '2016-10-08 18:43:05', '0', '0', '0', '0'), ('7', 'Gerenciador de Menu', '', '1', '0', '2016-10-08 18:44:32', '2016-10-08 18:44:32', '0', '0', '0', '0'), ('8', 'Newsletters', '', '1', '0', '2016-10-08 18:47:42', '2016-10-08 18:47:42', '0', '0', '0', '0'), ('9', 'Contas de usuário', '', '1', '0', '2016-10-08 18:48:13', '2016-10-08 18:48:13', '0', '0', '0', '0'), ('10', 'Configurações', '', '1', '0', '2016-10-08 18:51:28', '2016-10-08 18:51:28', '0', '0', '0', '0'), (11,	'Notificações',	'',	1,	0,	'2017-10-09 16:56:45',	NULL,	1,	0,	0,	0);");
        $this->db->query("INSERT INTO `modules_actions` VALUES ('1', '1', 'Listar postagens', 'admin/posts', '0', '2016-10-08 18:25:23', '2016-10-08 18:25:23', '0', '0', '0', '0'), ('2', '1', 'Adicionar postaagem', 'admin/posts/add', '0', '2016-10-08 18:25:40', '2016-10-08 18:25:40', '0', '0', '0', '0'), ('3', '1', 'Alterar postagem', 'admin/posts/edit/*', '0', '2016-10-08 18:25:57', '2016-10-08 18:25:57', '0', '0', '0', '0'), ('4', '1', 'Excluir postagem', 'admin/posts/delete/*', '0', '2016-10-08 18:26:14', '2016-10-08 18:26:14', '0', '0', '0', '0'), ('5', '1', 'Listar categorias de postagens', 'admin/categories', '0', '2016-10-08 18:26:45', '2016-10-08 18:26:45', '0', '0', '0', '0'), ('6', '1', 'Adicionar categoria de postagens', 'admin/categories/add', '0', '2016-10-08 18:27:03', '2016-10-08 18:27:03', '0', '0', '0', '0'), ('7', '1', 'Alterar categorias de postagens', 'admin/categories/edit/*', '0', '2016-10-08 18:27:17', '2016-10-08 18:27:17', '0', '0', '0', '0'), ('8', '1', 'Excluir categorias de postagens', 'admin/categories/delete/*', '0', '2016-10-08 18:27:31', '2016-10-08 18:27:31', '0', '0', '0', '0'), ('9', '2', 'Listar páginas', 'admin/pages', '0', '2016-10-08 18:28:59', '2016-10-08 18:28:59', '0', '0', '0', '0'), ('10', '2', 'Adicionar páginas', 'admin/pages/add', '0', '2016-10-08 18:29:12', '2016-10-08 18:29:12', '0', '0', '0', '0'), ('11', '2', 'Alterar páginas', 'admin/pages/edit/*', '0', '2016-10-08 18:29:23', '2016-10-08 18:29:23', '0', '0', '0', '0'), ('12', '2', 'Excluir páginas', 'admin/pages//delete/*', '0', '2016-10-08 18:29:35', '2016-10-08 18:29:35', '0', '0', '0', '0'), ('13', '3', 'Listar eventos', 'admin/agendas', '0', '2016-10-08 18:30:20', '2016-10-08 18:30:20', '0', '0', '0', '0'), ('14', '3', 'Adicionar eventos', 'admin/agendas/add', '0', '2016-10-08 18:30:28', '2016-10-08 18:30:28', '0', '0', '0', '0'), ('15', '3', 'Alterar eventos', 'admin/agendas/edit/*', '0', '2016-10-08 18:30:39', '2016-10-08 18:30:39', '0', '0', '0', '0'), ('16', '3', 'Excluir eventos', 'admin/agendas/delete/*', '0', '2016-10-08 18:30:49', '2016-10-08 18:30:49', '0', '0', '0', '0'), ('17', '4', 'Listar banners', 'admin/banners', '0', '2016-10-08 18:31:23', '2016-10-08 18:31:23', '0', '0', '0', '0'), ('18', '4', 'Adicionar banners', 'admin/banners/add', '0', '2016-10-08 18:31:39', '2016-10-08 18:31:39', '0', '0', '0', '0'), ('19', '4', 'Alterar banners', 'admin/banners/edit/*', '0', '2016-10-08 18:31:49', '2016-10-08 18:31:49', '0', '0', '0', '0'), ('20', '4', 'Excluir banners', 'admin/banners/delete/*', '0', '2016-10-08 18:31:58', '2016-10-08 18:31:58', '0', '0', '0', '0'), ('21', '5', 'Listar galerias', 'admin/galleries', '0', '2016-10-08 18:32:43', '2016-10-08 18:32:43', '0', '0', '0', '0'), ('22', '5', 'Adicionar galerias', 'admin/galleries/add', '0', '2016-10-08 18:32:58', '2016-10-08 18:32:58', '0', '0', '0', '0'), ('23', '5', 'Alterar galerias', 'admin/galleries/edit/*', '0', '2016-10-08 18:37:15', '2016-10-08 18:37:15', '0', '0', '0', '0'), ('24', '5', 'Excluir galerias', 'admin/galleries/delete/*', '0', '2016-10-08 18:37:34', '2016-10-08 18:37:34', '0', '0', '0', '0'), ('25', '5', 'Listar fotos da galeria', 'admin/galleries/pictures/*', '0', '2016-10-08 18:40:11', '2016-10-08 18:40:11', '0', '0', '0', '0'), ('26', '5', 'Adiciona foto na galeria individualmente', 'admin/galleries/addpicture/*', '0', '2016-10-08 18:40:53', '2016-10-08 18:40:53', '0', '0', '0', '0'), ('27', '5', 'Adiciona foto na galeria em massa', 'admin/galleries/addmass/*', '0', '2016-10-08 18:41:17', '2016-10-08 18:41:17', '0', '0', '0', '0'), ('28', '5', 'Alterar fotos da galeria', 'admin/galleries/editpicture/*', '0', '2016-10-08 18:42:00', '2016-10-08 18:42:00', '0', '0', '0', '0'), ('29', '5', 'Apagar foto da galeria', 'admin/galleries/delpicture/*', '0', '2016-10-08 18:42:25', '2016-10-08 18:42:25', '0', '0', '0', '0'), ('30', '6', 'Listar vídeos', 'admin/videos', '0', '2016-10-08 18:43:13', '2016-10-08 18:43:13', '0', '0', '0', '0'), ('31', '6', 'Adicionar vídeo', 'admin/videos/add', '0', '2016-10-08 18:43:21', '2016-10-08 18:43:21', '0', '0', '0', '0'), ('32', '6', 'Alterar vídeo', 'admin/videos/edit/*', '0', '2016-10-08 18:43:35', '2016-10-08 18:43:35', '0', '0', '0', '0'), ('33', '6', 'Apagar vídeo', 'admin/videos/delete/*', '0', '2016-10-08 18:43:47', '2016-10-08 18:43:47', '0', '0', '0', '0'), ('34', '7', 'Listar menus', 'admin/menus', '0', '2016-10-08 18:44:50', '2016-10-08 18:45:16', '0', '0', '0', '0'), ('35', '7', 'Adicionar menus', 'admin/menus/add', '0', '2016-10-08 18:45:26', '2016-10-08 18:45:26', '0', '0', '0', '0'), ('36', '7', 'Alterar menu', 'admin/menus/edit/*', '0', '2016-10-08 18:45:41', '2016-10-08 18:45:41', '0', '0', '0', '0'), ('37', '7', 'Apagar menu', 'admin/menus/delete/*', '0', '2016-10-08 18:45:53', '2016-10-08 18:45:53', '0', '0', '0', '0'), ('38', '7', 'Adicionar item de menu', 'admin/menus/additem/*', '0', '2016-10-08 18:46:26', '2016-10-08 18:46:26', '0', '0', '0', '0'), ('39', '7', 'Alterar item de menu', 'admin/menus/edititem/*', '0', '2016-10-08 18:46:45', '2016-10-08 18:46:45', '0', '0', '0', '0'), ('40', '7', 'Apagar item de menu', 'admin/menus/deleteitem/*', '0', '2016-10-08 18:47:01', '2016-10-08 18:47:01', '0', '0', '0', '0'), ('41', '8', 'Listar emails', 'admin/newsletters', '0', '2016-10-08 18:47:50', '2016-10-08 18:47:50', '0', '0', '0', '0'), ('42', '9', 'Listar usuários', 'admin/accounts', '0', '2016-10-08 18:48:21', '2016-10-08 18:48:21', '0', '0', '0', '0'), ('43', '9', 'Adicionar usuário', 'admin/accounts/add', '0', '2016-10-08 18:48:35', '2016-10-08 18:48:35', '0', '0', '0', '0'), ('44', '9', 'Alterar usuários', 'admin/accounts/edit/*', '0', '2016-10-08 18:48:49', '2016-10-08 18:48:49', '0', '0', '0', '0'), ('45', '9', 'Apagar usuário', 'admin/accounts/delete/*', '0', '2016-10-08 18:49:10', '2016-10-08 18:49:10', '0', '0', '0', '0'), ('46', '9', 'Alterar senha de usuários', 'admin/accounts/changepassword/*', '0', '2016-10-08 18:49:57', '2016-10-08 18:49:57', '0', '0', '0', '0'), ('47', '9', 'Listar IP´s manidos', 'admin/ipbanneds', '0', '2016-10-08 18:50:19', '2016-10-08 18:50:19', '0', '0', '0', '0'), ('48', '9', 'Banir um IP', 'admin/ipbanneds/add', '0', '2016-10-08 18:50:32', '2016-10-08 18:50:32', '0', '0', '0', '0'), ('49', '9', 'Apagar um IP banido', 'admin/ipbanneds/delete/*', '0', '2016-10-08 18:51:04', '2016-10-08 18:51:04', '0', '0', '0', '0'), ('50', '10', 'Visualizar configurações', 'admin/configuracoes', '0', '2016-10-08 18:52:09', '2016-10-08 18:52:09', '0', '0', '0', '0'), ('51', '10', 'Salvar configurações', 'admin/configuracoes/index', '0', '2016-10-08 18:52:18', '2016-10-08 18:52:18', '0', '0', '0', '0'), ('52','9','Lista de IP´s permitidos','admin/ipalloweds','0','2017-10-04 02:02:34',null,'1','0','0','0'), ('53','9','Permitir um IP','admin/ipalloweds/add','0','2017-10-04 02:03:14',null,'1','0','0','0'), ('54','9','Apagar um IP permitido','admin/ipalloweds/delete/*','0','2017-10-04 02:03:52',null,'1','0','0','0'), ('56',	'11',	'Listar todas as notificações',	'admin/notifications',	'1',	'2017-10-09 16:57:02',	NULL,	'1',	'0',	'0',	'0'), ('57',	'11',	'Excluir notificações',	'admin/notifications/delete/*',	'0',	'2017-10-09 17:00:39',	NULL,	'1',	'0',	'0',	'0'), ('58',	'11',	'Acessar notificação',	'admin/notifications/markasread/*',	'1',	'2017-10-09 17:01:08',	NULL,	'1',	'0',	'0',	'0'), ('59', '10', 'Alterar logomarca', 'admin/configuracoes/altlogo', '0', '2018-02-03 11:10:30', NULL, '1', '0', '0', '0'), ('60', '10', 'Alterar background', 'admin/configuracoes/altback', '0', '2018-02-03 11:11:38', NULL, '1', '0', '0', '0'), ('61', '10', 'Alterar favicon', 'admin/configuracoes/altfavicon', '0', '2018-02-03 11:12:24', NULL, '1', '0', '0', '0');");
        $this->db->query("INSERT INTO `categories` VALUES ('1', 'Categoria de exemplo', 'Categoria-de-exemplo', '', '0', 'list', null, null, '1', '0', '0', '0'), ('2', 'Sub-categoria de exemplo', 'Sub-categoria-de-exemplo', '', '1', 'list', null, null, '1', '0', '0', '0');");
        $this->db->query("INSERT INTO `menus` VALUES ('1', 'Menu principal', 'menu-principal', 'topo', 'lista', '2015-06-01 11:30:39', '2015-06-01 11:37:01', '0', '0', '0', '0');");
        $this->db->query("INSERT INTO `menu_itens` VALUES ('1', '1', 'Início', 'funcional', 'home', '', '1', '2015-06-01 13:08:00', '2015-06-02 16:02:10', '1', '0', '0', '0'), ('2', '1', 'Fotos', 'funcional', 'galleries', '', '3', '2015-06-01 18:03:37', '2017-04-27 00:46:23', '1', '0', '0', '0'), ('3', '1', 'Sobre', 'post', 'sobre', '', '5', '2015-06-01 22:40:27', '2015-06-02 17:14:47', '1', '0', '0', '0'), ('4', '1', 'Postagens', 'posts', '1', '', '2', '2015-06-02 14:08:34', '2015-06-02 17:14:13', '1', '0', '0', '0'), ('5', '1', 'Fale conosco', 'funcional', 'contact', '', '6', '2015-06-02 17:15:01', '2015-06-02 17:15:01', '1', '0', '0', '0'), ('6', '1', 'Vídeos', 'funcional', 'videos', '', '4', '2015-06-02 17:14:36', '2015-06-02 17:14:36', '1', '0', '0', '0'), ('7', '1', 'Usuários', 'funcional', 'users', '', '7', '2017-01-18 01:42:23', null, '1', '0', '0', '0');");
        $this->db->query("INSERT INTO `posts` VALUES ('1', 'Página inicial', 'Página inicial de exemplo do WPanel', 'pagina-inicial', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n', '0', 'wpanel, bem vindo, exemplo', '1', '1', '2014-11-09 23:17:53', '2014-12-18 20:09:59', '0', '0', '0', '0'), ('2', 'Sobre', 'Um exemplo de página específica para o menu.', 'sobre', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', '0', 'exemplo, pagina, sobre', '1', '1', '2014-11-09 23:29:16', '2014-11-09 23:29:16', '0', '0', '0', '0'), ('3', 'Postagem de exemplo', 'Exemplo de postagem', 'postagem-de-exemplo', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', 'null', 'demo, post, wpanel', '0', '1', '2014-11-08 23:46:38', '2014-11-10 00:04:22', '0', '0', '0', '0'), ('4', 'Segunda postagem de exemplo', 'Postagem de exemplo do Wpanel', 'segunda-postagem-de-exemplo', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', 'null', 'demo, post, exemplo, wpanel', '0', '1', '2014-11-09 23:47:15', '2014-11-10 01:12:01', '0', '0', '0', '0');");
        $this->db->query("INSERT INTO `posts_categories` VALUES ('1', '3', '1'), ('2', '4', '2');");
        $this->db->query("INSERT INTO `banners` VALUES ('1', 'Banner de exemplo #1', 'slide', '1', null, '4742fdb5443d36068de2ccd7181524e4.jpg', '1', '2014-11-10 12:00:00', '2014-11-10 12:00:00', '1', '0', '0', '0'), ('2', 'Banner de exemplo #2', 'slide', '2', null, 'baf049832810506469b65f68bffb8910.jpg', '1', '2014-11-10 12:00:00', '2014-11-10 12:00:00', '1', '0', '0', '0'), ('3', 'Banner de exemplo #2', 'slide', '2', null, 'f319e687ef3043e75bea52acf6032d8c.jpg', '1', '2014-11-10 12:00:00', '2014-11-10 12:00:00', '1', '0', '0', '0');");
    }

    /**
     * Drop the tables into the database.
     */
    public function down()
    {
        $this->dbforge->drop_table('ip_banned', true);
        $this->dbforge->drop_table('ip_alloweds', true);
        $this->dbforge->drop_table('ip_attempts', true);
        $this->dbforge->drop_table('log_access', true);
        $this->dbforge->drop_table('permissions', true);
        $this->dbforge->drop_table('modules_actions', true);
        $this->dbforge->drop_table('modules', true);
        $this->dbforge->drop_table('albuns', true);
        $this->dbforge->drop_table('banners', true);
        $this->dbforge->drop_table('captcha', true);
        $this->dbforge->drop_table('categories', true);
        $this->dbforge->drop_table('newsnotifications', true);
        $this->dbforge->drop_table('fotos', true);
        $this->dbforge->drop_table('menus', true);
        $this->dbforge->drop_table('menu_itens', true);
        $this->dbforge->drop_table('newsletter_email', true);
        $this->dbforge->drop_table('posts', true);
        $this->dbforge->drop_table('posts_categories', true);
        $this->dbforge->drop_table('videos', true);
        $this->dbforge->drop_table('accounts', true);
        $this->dbforge->drop_table('migrations', true);
    }

}
