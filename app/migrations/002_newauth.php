<?php 

class Migration_newauth extends CI_Migration
{
	public function up()
	{
		// Renomeia a tabela 'users' para fins de recuperação.
		$this->dbforge->rename_table('users', 'users_bkp');

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

		// Cria a tabela de perfil do usuário
		$fields = array(
	        'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
	        ),
	        'user_id' => array(
	        	'type' => 'INT',
	        	'null' => FALSE
	        ),
	        'nome' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => TRUE,
	        ),
	        'avatar' => array(
                'type' =>'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
	        ),
	        'skin' => array(
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => TRUE,
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
		$this->dbforge->add_key('user_id');
		$this->dbforge->create_table('users_profile', true);

		// Cria a tabela ip_attempts
		$fields = array(
			'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
	        ),
	        'ip_adress' => array(
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
    			'constraint' => 1,
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
		$this->dbforge->create_table('modules', true);

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
	        'user_id' => array(
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
		$this->dbforge->add_key('user_id');
		$this->dbforge->create_table('permissions', true);

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
			'ip_adress' => array(
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

		//TODO Lembrar mais alguma tabela...

	}

	public function down()
	{
		// Exclui a tabela 'users' nova.
		$this->dbforge->drop_table('accounts');
		// Restaura a tabela 'users' antiga.
		$this->dbforge->rename_table('users_bkp', 'users');
		// Exclui a tabela 'users_profile'.
		$this->dbforge->drop_table('users_profile');
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