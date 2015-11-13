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

class Migration_Novadashboard extends CI_Migration {

	public function up()
	{
		$fields = array(
			'user_id' => array('type' => 'int(11)', 'after'=>'id')
		);
		$this->dbforge->add_column('videos', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('videos', 'user_id');
	}
}