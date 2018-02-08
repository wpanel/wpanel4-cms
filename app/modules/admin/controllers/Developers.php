<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Developers.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Developers extends Authenticated_admin_controller
{
    
    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->language_file = 'wpn_developers_lang';
        $this->model_file = 'DevelopersModel';
        parent::__construct();
    }
    
    public function index()
    {
        $this->render();
    }
    
    /**
     * Acompanha os logs do CodeIgniter caso esteja ativado nas configurações.
     * 
     * @param string $log_file
     */
    public function logs($log_file = null)
    {
        if ($log_file === null) {
            
            if ($this->config->item('log_threshold') == 0) {
                $listagem = '<span class="text-danger">'.wpn_lang('msg_log_disabled').'</span>';
            } else {
                // Faz a listagem dos arquivos de log.
                $this->load->helper('directory');
                $this->load->library('table');
                // Template da tabela
                $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
                $this->table->set_heading(wpn_lang('log_filename'), wpn_lang('wpn_actions'));
                $map = directory_map(APPPATH . 'logs/', 0, false);
                for ($i = 0; $i < sizeof($map); $i++) {
                    if($map[$i] != 'index.html'){
                        $this->table->add_row(
                            str_replace('.php', '', $map[$i]), 
                            '<div class="btn-group btn-group-xs">'.
                            anchor('admin/developers/logs/'.str_replace('.php', '', $map[$i]), glyphicon('eye-open'), array('class' => 'btn btn-xs btn-default')) . 
                            anchor('admin/developers/deletelog/'.str_replace('.php', '', $map[$i]), glyphicon('trash'), array('class' => 'btn btn-xs btn-default', 'data-confirm' => wpn_lang('msg_confirm_delete'))) .
                            '</div>'
                        );
                    }
                }
                $listagem = $this->table->generate();
            }
            $this->set_var('listagem', $listagem);
            $this->render();
        } else {
            // Faz a visualização do arquivo de log.
            $this->load->helper('file');
            $string = "TYPE  - DATE                --> MESSAGE\n";
            $string .= "----------------------------------------";
            $string .= read_file(APPPATH . 'logs/'.$log_file.'.php');
            $string = str_replace("<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n", '', $string);
            $this->set_var('content', $string);
            $this->view('admin/developers/readlog')->render();
        }
    }
    
    /**
     * Gerencia os backups do banco de dados.
     * 
     * @param int $new_backup Passe 1 para gerar o backup.
     */
    public function backups($new_backup = null)
    {
        // Checa a compatibilidade do backup com o driver configurado.
        $compatible = $this->_check_dbdriver();
        
        if ($new_backup == 1) {
            
            if( ! $compatible)
                $this->set_message(wpn_lang('msg_compatibility'), 'info', 'admin/developers/backups');
            
            $filename = 'Wpanelcms-backup-' . date('Y-d-m_H-i-s') . '.sql';
            $this->load->dbutil();
            $prefs = array(
                'format' => 'txt',
                'add_drop' => TRUE,
                'add_insert' => TRUE,
                'newline' => "\n"
            );
            $backup = $this->dbutil->backup($prefs);
            $this->load->helper('file');
            if ( ! write_file( FCPATH . 'media/backupdb/' . $filename, $backup))
                $this->set_message(wpn_lang('msg_bkp_error'), 'danger', 'admin/developers/backups');
            else
                $this->set_message(wpn_lang('msg_bkp_success'), 'success', 'admin/developers/backups');

        } else {
            // Faz a listagem dos arquivos de log.
            $this->load->helper('directory');
            $this->load->library('table');
            // Template da tabela
            $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
            $this->table->set_heading(wpn_lang('backup_filename'), wpn_lang('wpn_actions'));
            $map = directory_map(FCPATH . 'media/backupdb/', 0, false);//, array('index.html'));
            for ($i = 0; $i < sizeof($map); $i++) {
                if($map[$i] != 'index.html'){
                    $this->table->add_row(
                        str_replace('.php', '', $map[$i]), 
                        '<div class="btn-group btn-group-xs">'.
                        anchor('admin/developers/downloadbackup/'.$map[$i], glyphicon('download'), array('class' => 'btn btn-xs btn-default')). 
                        anchor('admin/developers/deletebackup/'.$map[$i], glyphicon('trash'), array('class' => 'btn btn-xs btn-default', 'data-confirm' => wpn_lang('msg_confirm_delete'))) .
                        '</div>'
                    );
                }
            }
            $this->set_var('compatible', $compatible);
            $this->set_var('listagem', $this->table->generate());
            $this->render();
        }
    }
    
    /**
     * Apaga um arquivo de log.
     * 
     * @param string $filename
     */
    public function deletelog($filename)
    {
        if(unlink(APPPATH.'logs/' . $filename . '.php'))
            $this->set_message(wpn_lang('msg_dellog_success'), 'success', 'admin/developers/logs');
        else
            $this->set_message(wpn_lang('msg_dellog_error'), 'danger', 'admin/developers/logs');
    }
    
    /**
     * Força o download de um backup gerado previamente.
     * 
     * @param string $filename
     */
    public function downloadbackup($filename)
    {
        $this->load->helper('download');
        force_download(FCPATH . 'media/backupdb/' . $filename, null);
    }
    
    /**
     * Esclui um arquivo de backup de banco de dados.
     * 
     * @param string $filename
     */
    public function deletebackup($filename)
    {
        if($this->wpanel->remove_media('backupdb/' . $filename))
            $this->set_message(wpn_lang('msg_delbkp_success'), 'success', 'admin/developers/backups');
        else
            $this->set_message(wpn_lang('msg_delbkp_error'), 'danger', 'admin/developers/backups');
    }
    
    public function modmigration($version = FALSE)
    {
        
//         print_r($this->migration->find_migrations());
        
        if ($version === FALSE) {

            // Faz a listagem dos arquivos de log.
            $this->load->helper('directory');
            $this->load->library('table');
            // Template da tabela
            $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
            $this->table->set_heading(wpn_lang('backup_filename'), '', wpn_lang('wpn_actions'));
            $map = directory_map(APPPATH . 'database/migrations/', 0, false);
            for ($i = 0; $i < sizeof($map); $i++) {
                if($map[$i] != 'index.html'){
                    
                    $temp_id = explode("_", $map[$i]);
                    $id_migration = $temp_id[0];
                    $filename = str_replace('.php', '', $map[$i]);
                    
                    if($temp_id[0] == $this->DevelopersModel->get_migration_version())
                        $label_versao = '<span class="label label-danger">'. wpn_lang('actual_version').'</span>';
                    else
                        $label_versao = '';
                    
                    $this->table->add_row(
                        $filename,
                        $label_versao, 
                        '<div class="btn-group btn-group-xs">'.
                        anchor('admin/developers/modmigration/'.$id_migration, glyphicon('refresh'), array('class' => 'btn btn-xs btn-default', 'data-confirm' => wpn_lang('msg_confirm_updateversion'))). 
                        anchor('admin/developers/downloadmigration/'.$filename, glyphicon('download'), array('class' => 'btn btn-xs btn-default')). 
                        anchor('admin/developers/deletemigration/'.$filename, glyphicon('trash'), array('class' => 'btn btn-xs btn-default', 'data-confirm' => wpn_lang('msg_confirm_delete'))) .
                        '</div>'
                    );
                }
            }
            
            $this->set_var('lista_migrations', form_dropdown('versao', $this->DevelopersModel->get_migration_list()));
            $this->set_var('listagem', $this->table->generate());
            $this->render();

        } else {
            // Executa a migração para uma versão específica.
            if ($this->migration->version($version) === FALSE)
                $this->set_message(wpn_lang('msg_updatemigration_error'), 'danger', 'admin/developers/modmigration');
            else
                $this->set_message(wpn_lang('msg_updatemigration_success'), 'success', 'admin/developers/modmigration');
        }
    }
    
    /**
     * Executa o migration para a última versão.
     */
    public function lastmigration()
    {
        if ($this->migration->latest() === FALSE)
            $this->set_message(wpn_lang('msg_updatemigration_error'), 'danger', 'admin/developers/modmigration');
        else
            $this->set_message(wpn_lang('msg_updatemigration_success'), 'success', 'admin/developers/modmigration');
    }

    /**
     * Carrega um novo arquivo de migração.
     */
    public function uploadmigration()
    {
        $config['upload_path'] = APPPATH . 'database/migrations/';
        $config['allowed_types']        = '*';
        $config['remove_spaces'] = TRUE;
        $config['file_ext_tolower'] = TRUE;

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('userfile'))
            $this->set_message(wpn_lang('msg_uploadmigration_success'), 'success', 'admin/developers/modmigration');
        else
            $this->set_message(wpn_lang('msg_uploadmigration_error'), 'danger', 'admin/developers/modmigration');
    }

    /**
     * Este método faz o download de um arquivo de migration.
     * 
     * @param string $filename
     */
    public function downloadmigration($filename) {
        $this->load->helper('download');
        force_download(APPPATH . 'database/migrations/' . $filename . '.php', null);
    }
    
    /**
     * Este método faz a excusão de um arquivo de migration.
     * 
     * @param string $filename
     */
    public function deletemigration($filename) {
        if(unlink(APPPATH.'database/migrations/' . $filename . '.php'))
            $this->set_message(wpn_lang('msg_delmigration_success'), 'success', 'admin/developers/modmigration');
        else
            $this->set_message(wpn_lang('msg_delmigration_error'), 'danger', 'admin/developers/modmigration');
    }
    
    /**
     * Verifica a compatibilidade do driver de banco de dados com o recurso
     * de backup do CodeIgniter.
     * 
     * @return bool
     */
    private function _check_dbdriver()
    {
        include FCPATH . 'config/database.php';
        switch ($db[ENVIRONMENT]['dbdriver']) {
            case 'mysqli':
                return TRUE;
                break;
            case 'mysql';
                return TRUE;
                break;
            default:
                return FALSE;
                break;
        }
    }
    
}