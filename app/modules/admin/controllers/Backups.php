<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Backup class generate an sql backup file from the mysql database.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Backups extends Authenticated_Controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Index forbidden.
     */
    public function index()
    {
        redirect('admin');
    }

    /**
     * Execute the backup proccess.
     */
    public function execute()
    {

        $filename = 'wpanel-backup-' . date('d-m-Y-H-i-s') . '.sql';

        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $prefs = array(
            'format' => 'zip',
            'filename' => $filename,
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );

        $backup = & $this->dbutil->backup($prefs);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($filename . '.zip', $backup);
    }

}
