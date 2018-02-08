<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Esta é a classe do módulo de administração Ipbanneds, ela foi
 * gerada automaticamente pela ferramenta Wpanel-GEN para a criação
 * de códigos padrão para o Wpanel CMS.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 */
class Ipbanneds extends Authenticated_admin_controller
{

    /**
     * Class constructor
     */
    function __construct()
    {
        $this->model_file = 'ipban';
        $this->language_file = 'wpn_ipbanned_lang';
        parent::__construct();
    }

    /**
     * List IP's.
     */
    public function index()
    {
        $this->load->library('table');
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading('#', wpn_lang('field_ip'), wpn_lang('field_created_on'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->ipban->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/ipbanneds/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->ipban
                ->select('id, ip_address, created_on')
                ->limit($limit, $offset)
                ->find_all();
        foreach ($query as $row)
        {
            $this->table->add_row(
                    $row->id, $row->ip_address, mdate(config_item('user_date_format'), strtotime($row->created_on)),
                    // Ícones de ações
                    div(array('class' => 'btn-group btn-group-xs')) .
                    anchor('admin/ipbanneds/delete/' . $row->id, glyphicon('trash'), array('class'=>'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                    div(null, true)
            );
        }
        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }

    /**
     * Insert an IP.
     */
    public function add()
    {
        $this->form_validation->set_rules('ip_address', wpn_lang('field_ip'), 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->render();
        } else
        {
            $data = array();
            $data['ip_address'] = $this->input->post('ip_address');
            if ($this->ipban->insert($data))
                $this->set_message(wpn_lang('wpn_message_save_success'), 'success', 'admin/ipbanneds');
            else
                $this->set_message(wpn_lang('wpn_message_save_error'), 'danger', 'admin/ipbanneds');
        }
    }

    /**
     * Delete an IP.
     * 
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/ipbanneds');
        if ($this->ipban->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/ipbanneds');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/ipbanneds');
    }

}

// End of file modules/admin/controllers/Ipbanneds.php