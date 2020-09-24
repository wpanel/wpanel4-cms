<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Migration_Newmodulesetup class.
 *
 * This class modify initial database to the new modules setup schema.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 */
class Migration_Newmodulesetup extends CI_Migration
{

    /**
     * Initial version.
     * @var string
     */
    protected $initial_version = '0.0.0';

    /**
     * System modules.
     * @var array
     */
    protected $system_modules = [
        'gerenciador-de-menus',
        'gerenciador-de-leads',
        'contas-de-usuarios',
        'configuracoes',
        'notificacoes'
    ];

    /**
     * New fields for modules table.
     * @var array
     */
    protected $fields = [
        'name_id' => [
            'type' => 'varchar',
            'constraint' => 255,
            'comment' => 'Identificador do módulo.',
            'AFTER' => 'id',
            'default' => '0',
            'null' => true
        ],
        'description' => [
            'type' => 'text',
            'comment' => 'Descrição do módulo.',
            'AFTER' => 'name',
//            'default' => '',
            'null' => true
        ],
        'author_name' => [
            'type' => 'varchar',
            'constraint' => 255,
            'comment' => 'Nome do autor.',
            'AFTER' => 'order',
            'default' => '',
            'null' => true
        ],
        'author_email' => [
            'type' => 'varchar',
            'constraint' => 255,
            'comment' => 'E-mail do autor.',
            'AFTER' => 'author_name',
            'default' => '',
            'null' => true
        ],
        'author_website' => [
            'type' => 'varchar',
            'constraint' => 255,
            'comment' => 'Site do autor.',
            'AFTER' => 'author_email',
            'default' => '',
            'null' => true
        ],
        'version' => [
            'type' => 'varchar',
            'constraint' => 10,
            'comment' => 'Versão do módulo.',
            'BEFORE' => 'status',
            'default' => '0.0.1',
            'null' => true
        ],
        'status' => [
            'type' => 'int',
            'constraint' => 1,
            'comment' => 'Status ativo = 1, inativo = 0.',
            'AFTER' => 'order',
            'default' => '0',
            'null' => true
        ],
        'system' => [
            'type' => 'int',
            'constraint' => 1,
            'comment' => 'Módulo do sistema: 1= Sim, 0= Não.',
            'AFTER' => 'status',
            'default' => '0',
            'null' => true
        ]
    ];

    /**
     * Run migration.
     */
    public function up()
    {
        $this->dbforge->add_column('modules', $this->fields);
        $this->update_old_modules();
    }

    /**
     * Rollback migration.
     */
    public function down()
    {
        $this->dbforge->drop_column('modules', 'name_id', TRUE);
        $this->dbforge->drop_column('modules', 'author_name', TRUE);
        $this->dbforge->drop_column('modules', 'author_email', TRUE);
        $this->dbforge->drop_column('modules', 'author_website', TRUE);
        $this->dbforge->drop_column('modules', 'status', TRUE);
        $this->dbforge->drop_column('modules', 'version', TRUE);
        $this->dbforge->drop_column('modules', 'description', TRUE);
        $this->dbforge->drop_column('modules', 'system', TRUE);
    }

    /**
     * This method updates the old records from modules table.
     */
    private function update_old_modules()
    {
        $modules = $this->db->get('modules');
        foreach ($modules->result() as $module) {
            $name_id = strtolower(url_title(convert_accented_characters($module->name)));
            $data = [
                'name_id' => $name_id,
                'description' => '',
                'author_name' => 'Wpanel Core Team',
                'author_email' => 'wpanel@wpanel.org',
                'author_website' => 'https://wpanel.org',
                'version' => $this->initial_version,
                'status' => 1,
                'system' => in_array($name_id, $this->system_modules)
            ];
            $this->db->where('id', $module->id);
            $this->db->update('modules', $data);
        }
    }

}