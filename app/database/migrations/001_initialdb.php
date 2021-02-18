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
        'href' => array(
            'type' => 'varchar',
            'constraint' => 200,
            'null' => TRUE
        ),
        'target' => array(
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
         * Loden Ipsum, classic demo text.
         */
        $loren_ipsum = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>';

        /**
         * Modules data.
         */
        $modules_data = array(
            array(
                'name' => 'Postagens',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Páginas',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Eventos',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Banners',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Galerias',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Vídeos',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Gerenciador de menus',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Gerenciador de Leads',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Contas de usuários',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Configurações',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0',
            ),
            array(
                'name' => 'Notificações',
                'icon' => '',
                'show_in_menu' => '1',
                'order' => '0'
            )
        );        

        /**
         * Module itens data.
         */
        $moduleactions_data = array(
            array(
                'module_id' => '1',
                'description' => 'Listar postagens', 
                'link' => 'admin/posts', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '1',
                'description' => 'Adicionar postagem', 
                'link' => 'admin/posts/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '1',
                'description' => 'Alterar postagem', 
                'link' => 'admin/posts/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '1',
                'description' => 'Excluir postagem', 
                'link' => 'admin/posts/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '1',
                'description' => 'Listar categorias de postagens', 
                'link' => 'admin/categories', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '1',
                'description' => 'Adicionar categoria de postagens', 
                'link' => 'admin/categories/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '1',
                'description' => 'Alterar categorias de postagens', 
                'link' => 'admin/categories/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '1',
                'description' => 'Excluir categorias de postagens', 
                'link' => 'admin/categories/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '2',
                'description' => 'Listar páginas', 
                'link' => 'admin/pages', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '2',
                'description' => 'Adicionar páginas', 
                'link' => 'admin/pages/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '2',
                'description' => 'Alterar páginas', 
                'link' => 'admin/pages/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '2',
                'description' => 'Excluir páginas', 
                'link' => 'admin/pages/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '3',
                'description' => 'Listar eventos', 
                'link' => 'admin/agendas', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '3',
                'description' => 'Adicionar eventos', 
                'link' => 'admin/agendas/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '3',
                'description' => 'Alterar eventos', 
                'link' => 'admin/agendas/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '3',
                'description' => 'Excluir eventos', 
                'link' => 'admin/agendas/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '4',
                'description' => 'Listar banners', 
                'link' => 'admin/banners', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '4',
                'description' => 'Adicionar banners', 
                'link' => 'admin/banners/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '4',
                'description' => 'Alterar banners', 
                'link' => 'admin/banners/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '4',
                'description' => 'Excluir banners', 
                'link' => 'admin/banners/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Listar galerias', 
                'link' => 'admin/galleries', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Adicionar galerias', 
                'link' => 'admin/galleries/add', 
                'whitelist' => '0'
            ),
            array(
                'module_id' => '5',
                'description' => 'Alterar galerias', 
                'link' => 'admin/galleries/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Excluir galerias', 
                'link' => 'admin/galleries/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Listar fotos da galeria', 
                'link' => 'admin/galleries/pictures/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Adiciona foto na galeria individualmente', 
                'link' => 'admin/galleries/addpicture/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Adiciona foto na galeria em massa', 
                'link' => 'admin/galleries/addmass/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Alterar fotos da galeria', 
                'link' => 'admin/galleries/editpicture/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '5',
                'description' => 'Apagar foto da galeria', 
                'link' => 'admin/galleries/delpicture/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '6',
                'description' => 'Listar vídeos',
                'link' => 'admin/videos', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '6',
                'description' => 'Adicionar vídeo', 
                'link' => 'admin/videos/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '6',
                'description' => 'Alterar vídeo', 
                'link' => 'admin/videos/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '6',
                'description' => 'Apagar vídeo', 
                'link' => 'admin/videos/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '7',
                'description' => 'Listar menus',
                'link' => 'admin/menus', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '7',
                'description' => 'Adicionar menus', 
                'link' => 'admin/menus/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '7',
                'description' => 'Alterar menu', 
                'link' => 'admin/menus/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '7',
                'description' => 'Apagar menu', 
                'link' => 'admin/menus/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '7',
                'description' => 'Adicionar item de menu', 
                'link' => 'admin/menus/additem/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '7',
                'description' => 'Alterar item de menu', 
                'link' => 'admin/menus/edititem/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '7',
                'description' => 'Apagar item de menu', 
                'link' => 'admin/menus/deleteitem/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '8',
                'description' => 'Listar emails',
                'link' => 'admin/newsletters', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '8',
                'description' => 'Exportar emails',
                'link' => 'admin/newsletters/export', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '8',
                'description' => 'Limpar emails',
                'link' => 'admin/newsletters/clear', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Listar usuários',
                'link' => 'admin/accounts', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Adicionar usuário', 
                'link' => 'admin/accounts/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Alterar usuários', 
                'link' => 'admin/accounts/edit/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Apagar usuário', 
                'link' => 'admin/accounts/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Alterar senha de usuários', 
                'link' => 'admin/accounts/changepassword/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Listar IP´s manidos', 
                'link' => 'admin/ipbanneds', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Banir um IP', 
                'link' => 'admin/ipbanneds/add', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Apagar um IP banido', 
                'link' => 'admin/ipbanneds/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Lista de IP´s permitidos',
                'link' => 'admin/ipalloweds',
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Permitir um IP',
                'link' => 'admin/ipalloweds/add',
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '9',
                'description' => 'Apagar um IP permitido',
                'link' => 'admin/ipalloweds/delete/*',
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '10',
                'description' => 'Visualizar configurações', 
                'link' => 'admin/configuracoes', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '10',
                'description' => 'Salvar configurações', 
                'link' => 'admin/configuracoes/index', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '10',
                'description' => 'Alterar logomarca', 
                'link' => 'admin/configuracoes/altlogo', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '10',
                'description' => 'Alterar background', 
                'link' => 'admin/configuracoes/altback', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '10',
                'description' => 'Alterar favicon', 
                'link' => 'admin/configuracoes/altfavicon', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '11',
                'description' => 'Listar todas as notificações',
                 'link' => 'admin/notifications',  
                'whitelist' => '1'
            ), 
            array(
                'module_id' => '11',
                'description' => 'Excluir notificações', 
                'link' => 'admin/notifications/delete/*', 
                'whitelist' => '0'
            ), 
            array(
                'module_id' => '11',
                'description' => 'Acessar notificação',  
                'link' => 'admin/notifications/markasread/*', 
                'whitelist' => '1'
            ),
        );

        $post_data = array(
            array(
                'title' => 'Página inicial', 
                'description' => 'Página inicial de exemplo do WPanel', 
                'link' => 'pagina-inicial', 
                'content' => $loren_ipsum, 
                'image' => null, 
                'tags' => 'wpanel, bem vindo, exemplo', 
                'page' => '1', 
                'status' => '1'
            ),
            array(
                'title' => 'Sobre', 
                'description' => 'Um exemplo de página específica para o menu.', 
                'link' => 'sobre', 
                'content' => $loren_ipsum, 
                'image' => null, 
                'tags' => 'exemplo, pagina, sobre', 
                'page' => '1', 
                'status' => '1'
            ),
            array(
                'title' => 'Postagem de exemplo', 
                'description' => 'Exemplo de postagem', 
                'link' => 'postagem-de-exemplo', 
                'content' => $loren_ipsum, 
                'image' => null, 
                'tags' => 'demo, post, wpanel', 
                'page' => '0', 
                'status' => '1'
            ),
            array(
                'title' => 'Segunda postagem de exemplo', 
                'description' => 'Postagem de exemplo do Wpanel', 
                'link' => 'segunda-postagem-de-exemplo', 
                'content' => $loren_ipsum, 
                'image' => null, 
                'tags' => 'demo, post, exemplo, wpanel', 
                'page' => '0', 
                'status' => '1'
            )
        );

        /**
         * Category data.
         */
        $category_data = array(
            array(
                'title' => 'Categoria de exemplo',
                'link' => 'categoria-de-exemplo',
                'description' => 'Uma categoria de postagens de exemplo. Esta categoria tem como visualização o padrão MOSAICO para as postagens.',
                'category_id' => 0,
                'view' => 'mosaic'
            ),
            array(
                'title' => 'Sub-categoria de exemplo',
                'link' => 'sub-categoria-de-exemplo',
                'description' => 'Uma sub-categoria de postagens de exemplo. Ela é relacionada a Categoria de Exemplo e tem como visualização o padrão LISTA para as postagens.',
                'category_id' => 1,
                'view' => 'list'
            )
        );

        /**
         * Banners data.
         */
        $banners_data = array(
            array(
                'title' => 'Demo slide banner #1',
                'position' => 'slide',
                'sequence' => '1',
                'type' => NULL,
                'content' => '3a36afa4aad184e2165c3bcea0ecf727.jpg',
                'href' => NULL,
                'target' => NULL,
                'status' => '1',
            ),
            array(
                'title' => 'Demo slide banner #2',
                'position' => 'slide',
                'sequence' => '2',
                'type' => NULL,
                'content' => '547f5ec4da3af086723a52f155f952d9.jpg',
                'href' => NULL,
                'target' => NULL,
                'status' => '1',
            ),
            array(
                'title' => 'Demo sidebar banner #1',
                'position' => 'sidebar',
                'sequence' => '1',
                'type' => NULL,
                'content' => '18fa9f012f6175acce3ba754aef61c4d.png',
                'href' => NULL,
                'target' => NULL,
                'status' => '1'
            ),
            array(
                'title' => 'Demo footer banner #1',
                'position' => 'footer',
                'sequence' => '1',
                'type' => NULL,
                'content' => 'ec91144f7c04face18d8c030a6ee2978.png',
                'href' => NULL,
                'target' => NULL,
                'status' => '1'
            )
        );

        /**
         * Menu data.
         */
        $menu_data = array(
            'nome' => 'Menu principal', 
            'slug' => 'menu-principal', 
            'posicao' => 'topo', 
            'estilo' => 'lista'
        );

        /**
         * Menu itens data.
         */
        $menuitem_data = array(
            array(
                'menu_id' => 1,
                'label' => 'Início',
                'tipo' => 'funcional',
                'href' => 'home',
                'slug' => '',
                'ordem' => '1',
            ),
            array(
                'menu_id' => 1,
                'label' => 'Sobre',
                'tipo' => 'post',
                'href' => 'sobre',
                'slug' => '',
                'ordem' => '2',
            ),
            array(
                'menu_id' => 1,
                'label' => 'Postagens',
                'tipo' => 'posts',
                'href' => '1',
                'slug' => '',
                'ordem' => '3',
            ),
            array(
                'menu_id' => 1,
                'label' => 'Fotos',
                'tipo' => 'funcional',
                'href' => 'galleries',
                'slug' => '',
                'ordem' => '4',
            ),
            array(
                'menu_id' => 1,
                'label' => 'Vídeos',
                'tipo' => 'funcional',
                'href' => 'videos',
                'slug' => '',
                'ordem' => '5',
            ),
            array(
                'menu_id' => 1,
                'label' => 'Contato',
                'tipo' => 'funcional',
                'href' => 'contact',
                'slug' => '',
                'ordem' => '6',
            ),
            array(
                'menu_id' => 1,
                'label' => 'Usuários',
                'tipo' => 'funcional',
                'href' => 'users',
                'slug' => '',
                'ordem' => '7'
            )
        );

        /**
         * Post x Categories data.
         */
        $postcategory_data = array(
            array(
                'post_id' => 3,
                'category_id' => 1
            ),
            array(
                'post_id' => 4,
                'category_id' => 2
            ),

        );        

        $this->db->insert_batch('modules', $modules_data);
        $this->db->insert_batch('modules_actions', $moduleactions_data);
        $this->db->insert_batch('categories', $category_data);
        $this->db->insert_batch('banners', $banners_data);
        $this->db->insert('menus', $menu_data);
        $this->db->insert_batch('menu_itens', $menuitem_data);
        $this->db->insert_batch('posts', $post_data);
        $this->db->insert_batch('posts_categories', $postcategory_data);

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
