<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletters extends MX_Controller
{

    function __construct()
    {
        $this->auth->check_permission();
        $this->load->model('newsletter');
        $this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
    }

    public function index()
    {
        $content_vars = array();
        $contatos = $this->newsletter->get_list()->result();
        $content_vars['contatos'] = $contatos;
        $this->wpanel->load_view('newsletter/index', $content_vars);
    }

    public function export()
    {

        $filename = 'wpanel-newsletters-' . date('d-m-Y-H-i-s') . '.csv';

        // Load the DB utility class
        $this->load->dbutil();

        $query = $this->db->query("SELECT id AS 'Código', nome AS 'Nome', email AS 'E-mail', created AS 'Data', ipaddress AS 'IP' FROM newsletter_email");

        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';

        $csv = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($filename, $csv);
    }

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
