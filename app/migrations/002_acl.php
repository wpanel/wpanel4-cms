<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * -------------------------------------------------------------------------------------------------
 * Este arquivo de migração contém as alterações no banco de dados para a implementação inicial
 * do controle de acesso de usuários do painel de controle.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @version 0.1
 * -------------------------------------------------------------------------------------------------
 */

class Migration_Acl extends CI_Migration {

	public function up()
	{
		$fields = array(
			'permissions' => array('type' => 'LONGTEXT', 'after'=>'role')
		);
		$this->dbforge->add_column('users', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('users', 'permissions');
	}
}