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

$lang['msg_confirm_delete'] = "Deseja mesmo excluir? Esta ação não poderá ser desfeita!";
$lang['msg_compatibility'] = "Seu banco de dados não fornece compatibilidade para gerar backups.";
$lang['msg_bkp_success'] = "Backup criado com sucesso!";
$lang['msg_bkp_error'] = "Não foi possível criar o backup do banco de dados.";
$lang['msg_delbkp_success'] = "Backup excluído com sucesso!";
$lang['msg_delbkp_error'] = "Não foi possível excluir o backup.";
$lang['msg_dellog_success'] = "Log excluído com sucesso!";
$lang['msg_dellog_error'] = "Não foi possível excluir o log.";
$lang['msg_log_disabled'] = "As mensagens de log estão desabilitadas nas suas configurações. Altere o valor do Treshold em /app/config/config.php";