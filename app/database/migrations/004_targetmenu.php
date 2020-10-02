<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Migration_Targetmenu class.
 *
 * This class add target to the menu items.
 *
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Migration_Targetmenu extends CI_Migration
{

    /**
     * New field
     * @var array[]
     */
    protected $fields = [
        'target' => [
            'type' => 'varchar',
            'constraint' => 10,
            'comment' => 'Link _target property.',
            'AFTER' => 'href',
            'default' => '_self',
            'null' => true
        ]
    ];

    /**
     * Run migration.
     */
    public function up()
    {
        $this->dbforge->add_column('menu_itens', $this->fields);
        $this->db->update('menu_itens', ['target' => '_self']);
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        $this->dbforge->drop_column('menu_itens', 'target', TRUE);
    }

}