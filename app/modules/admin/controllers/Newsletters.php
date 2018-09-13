<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Newsletters class
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Newsletters extends Authenticated_admin_controller
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $this->model_file = 'newsletter';
        $this->language_file = 'wpn_newsletter_lang';
        parent::__construct();
    }

    /**
     * Lista de emails.
     */
    public function index()
    {
        $contatos = $this->newsletter
                ->select('id, nome, email, created_on, ipaddress')
                ->find_all();
        $this->set_var('contatos', $contatos);
        $this->render();
    }

    /**
     * Exporta a lista de emails para um arquivo CSV.
     */
    public function export()
    {

        $filename = 'wpanel-newsletters-' . date('d-m-Y-H-i-s') . '.csv';

        // Load the DB utility class
        $this->load->dbutil();

        $query = $this->db->query("SELECT id AS '".wpn_lang('field_id')."', nome AS '".wpn_lang('field_name')."', email AS '".wpn_lang('field_email')."', created_on AS '".wpn_lang('field_created_on')."', ipaddress AS '".wpn_lang('field_ip')."' FROM newsletter_email");

        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';

        $csv = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($filename, $csv);
    }

    /**
     * Limpa a lista de emails.
     */
    public function clear()
    {
        if ($this->newsletter->empty_table('newsletter_email'))
            $this->set_message(wpn_lang('message_clear_ok'), 'success', 'admin/newsletters');
        else
        $this->set_message(wpn_lang('message_clear_error'), 'success', 'admin/newsletters');
    }

}
