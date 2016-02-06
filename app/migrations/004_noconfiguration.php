<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * -------------------------------------------------------------------------------------------------
 * Este arquivo de migração contém as alterações no banco de dados para a implementação
 * do novo controle de configurações com config.json.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @version 0.1
 * -------------------------------------------------------------------------------------------------
 */
class Migration_Noconfiguration extends CI_Migration {

    public function up() {
        $this->dbforge->drop_table('configuracoes');
    }

    public function down() {
        $this->dbforge->add_field("id");
        $this->dbforge->add_field("`site_titulo` varchar(100) DEFAULT NULL");
        $this->dbforge->add_field("`site_desc` text");
        $this->dbforge->add_field("`site_tags` text");
        $this->dbforge->add_field("`site_contato` varchar(60) DEFAULT NULL");
        $this->dbforge->add_field("`site_telefone` varchar(15) DEFAULT NULL");
        $this->dbforge->add_field("`link_instagram` varchar(100) DEFAULT NULL");
        $this->dbforge->add_field("`link_twitter` varchar(100) DEFAULT NULL");
        $this->dbforge->add_field("`link_facebook` varchar(100) DEFAULT NULL");
        $this->dbforge->add_field("`link_likebox` varchar(100) DEFAULT NULL");
        $this->dbforge->add_field("`copyright` text");
        $this->dbforge->add_field("`addthis_uid` varchar(30) DEFAULT NULL");
        $this->dbforge->add_field("`logomarca` varchar(200) DEFAULT NULL");
        $this->dbforge->add_field("`background` varchar(200) DEFAULT NULL");
        $this->dbforge->add_field("`bgcolor` varchar(15) DEFAULT NULL");
        $this->dbforge->add_field("`texto_contato` text");
        $this->dbforge->add_field("`usa_smtp` tinyint(1) NOT NULL");
        $this->dbforge->add_field("`smtp_servidor` varchar(100) NOT NULL");
        $this->dbforge->add_field("`smtp_porta` int(3) NOT NULL");
        $this->dbforge->add_field("`smtp_usuario` varchar(100) NOT NULL");
        $this->dbforge->add_field("`smtp_senha` varchar(100) NOT NULL");
        $this->dbforge->add_field("`google_analytics` text");
        $this->dbforge->add_field("`home_tipo` varchar(10) DEFAULT NULL");
        $this->dbforge->add_field("`home_id` varchar(10) DEFAULT NULL");

        $this->dbforge->create_table('configuracoes', true);
    }

}
