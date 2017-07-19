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
class Newsletters extends Authenticated_Controller
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
     * List of emails.
     */
    public function index()
    {
        $content_vars = array();
        $contatos = $this->newsletter->find_all();
        $this->set_var('contatos', $contatos);
        $this->render();
    }

    /**
     * Export the list do CSV.
     */
    public function export()
    {

        $filename = 'wpanel-newsletters-' . date('d-m-Y-H-i-s') . '.csv';

        // Load the DB utility class
        $this->load->dbutil();

        $query = $this->db->query("SELECT id AS 'Código', nome AS 'Nome', email AS 'E-mail', created_on AS 'Data', ipaddress AS 'IP' FROM newsletter_email");

        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';

        $csv = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($filename, $csv);
    }

    /**
     * emtpy the email list.
     */
    public function clear()
    {
        if ($this->newsletter->empty_table('newsletter_email'))
        {
            $this->session->set_flashdata('msg_sistema', 'Limpeza efetuada com sucesso.');
            redirect('admin/newsletters');
        } else
        {
            $this->session->set_flashdata('msg_sistema', 'Erro ao efetuar a limpeza.');
            redirect('admin/newsletters');
        }
    }

}
