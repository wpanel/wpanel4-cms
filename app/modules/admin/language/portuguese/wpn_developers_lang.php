<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Arquivo de idioma do módulo admin Developers.
 *
 * @language Portuguese
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */

$lang['module_title'] = "Desenvolvedor";
$lang['module_description'] = "Opções específicas para desenvolvedores.";
$lang['module_log_list'] = "Lista de logs";
$lang['module_log_reading'] = "Visualização de logs";
$lang['log_filename'] = "Arquivo de log";

$lang['module_backup_list'] = "Lista de backups";
$lang['backup_filename'] = "Arquivo de backup";

$lang['module_migration_list'] = "Lista de arquivos de migração";
$lang['module_add_migration'] = "Enviar arquivo de migração";
$lang['bot_new_migration'] = "Enviar arquivo de migração";
$lang['bot_update_lastversion'] = "Atualizar para a última versão";
$lang['actual_version'] = "Versão atual";
$lang['field_nome'] = "Selecione o arquivo";

$lang['msg_confirm_delete'] = "Deseja mesmo excluir? Esta ação não poderá ser desfeita!";
$lang['msg_compatibility'] = "Seu banco de dados não fornece compatibilidade para gerar backups.";
$lang['msg_bkp_success'] = "Backup criado com sucesso!";
$lang['msg_bkp_error'] = "Não foi possível criar o backup do banco de dados.";
$lang['msg_delbkp_success'] = "Backup excluído com sucesso!";
$lang['msg_delbkp_error'] = "Não foi possível excluir o backup.";
$lang['msg_dellog_success'] = "Log excluído com sucesso!";
$lang['msg_dellog_error'] = "Não foi possível excluir o log.";
$lang['msg_log_disabled'] = "As mensagens de log estão desabilitadas nas suas configurações. Altere o valor do Treshold em /app/config/config.php";
$lang['msg_confirm_updateversion'] = "Deseja mesmo atualizar a base de dados para esta versão?";
$lang['msg_confirm_update_lastversion'] = "Deseja mesmo atualizar a base de dados para a última versão?";
$lang['msg_updatemigration_success'] = "Base de dados atualizada com sucesso!";
$lang['msg_updatemigration_error'] = "Erro ao atualizar a base de dados.";
$lang['msg_uploadmigration_success'] = "Arquivo de migração enviado com sucesso!";
$lang['msg_uploadmigration_error'] = "Erro ao enviar o arquivo de migração.";
$lang['msg_delmigration_success'] = "Arquivo de migração excluído com sucesso!";
$lang['msg_delmigration_error'] = "Erro ao excluir o arquivo de migração.";