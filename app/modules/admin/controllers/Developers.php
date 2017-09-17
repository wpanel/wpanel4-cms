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
        // $this->model_file = 'banner';
        $this->language_file = 'wpn_developers_lang';
        parent::__construct();
    }
    
    public function index()
    {
        $this->render();
    }
    
    public function logs($log_file = null)
    {
        if ($log_file === null) {
            
            if ($this->config->item('log_threshold') == 0) {
                $listagem = '<span class="text-danger">As mensagens de log estão desabilitadas nas suas configurações. Altere o valor do Treshold em /app/config/config.php</span>';
            } else {
                // Faz a listagem dos arquivos de log.
                $this->load->helper('directory');
                $this->load->library('table');
                // Template da tabela
                $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
                $this->table->set_heading(wpn_lang('log_filename'), wpn_lang('wpn_actions'));
                $map = directory_map(APPPATH . 'logs/', 0, false);
                for ($i = 1; $i < sizeof($map); $i++) {
                    $this->table->add_row(
                        str_replace('.php', '', $map[$i]), 
                        anchor('admin/developers/logs/'.str_replace('.php', '', $map[$i]), glyphicon('eye-open'), array('class' => 'btn btn-xs btn-default'))
                    );
                }
                $listagem = $this->table->generate();
            }
            $this->set_var('listagem', $listagem);
            $this->render();
        } else {
            // Faz a visualização do arquivo de log.
            $this->load->helper('file');
            //TODO Incluir o texto abaixo nas traduções.
            $string = "TIPO  - DATA                --> MENSAGEM\n";
            $string .= "----------------------------------------";
            $string .= read_file(APPPATH . 'logs/'.$log_file.'.php');
            $string = str_replace("<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n", '', $string);
            $this->set_var('conteudo', $string);
            $this->view('admin/developers/readlog')->render();
        }
    }
    
    public function backups($new_backup = false)
    {
        if ($new_backup === true) {
            // gera um novo backup
        } else {
            // lista os backups realizados com opção de download
            $this->render();
        }
    }
    
}