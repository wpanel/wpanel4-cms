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
class Developers extends Authenticated_Controller
{
    
    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->language_file = 'wpn_developers_lang';
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
    
    public function modmigration()
    {
        //echo "tela de manutanção das migraçãoes...\n";
        //echo "Versão: " . $this->migration->current();
        
        // Faz a listagem dos arquivos de log.
        $this->load->helper('directory');
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('backup_filename'), wpn_lang('wpn_actions'));
        $map = directory_map(APPPATH . 'database/migrations/', 0, false);
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
        //$this->set_var('compatible', $compatible);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
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