<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class notifications.
 *
 * @todo Traduzir os status e posições dos banners.
 * 
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 */
class Notifications extends Authenticated_admin_controller
{
    function __construct()
    {
        $this->model_file = 'notification';
        $this->language_file = 'wpn_notification_lang';
        parent::__construct();
    }
    
    /**
     * Lista todas as notificações.
     */
    public function index()
    {
        
        $this->load->library('table');
        // Template da tabela
        $this->table->set_template(array('table_open' => '<table id="grid" class="table table-condensed table-striped">'));
        $this->table->set_heading(wpn_lang('field_id'), wpn_lang('field_title'), wpn_lang('field_status'), wpn_lang('wpn_actions'));
        
        // Paginação
        // -------------------------------------------------------------------
        $limit = 10;
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);
        $total_rows = $this->notification->count_by('deleted', '0');
        $config = array();
        $config['base_url'] = site_url('admin/notifications/index/pag');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        // -------------------------------------------------------------------
        // Fim - Paginação
        
        $query = $this->notification->limit($limit, $offset)
                            ->select('id, title, created_on, status')
                            ->find_all();
        
        foreach ($query as $row)
        {
            $this->table->add_row(
                $row->id,
                anchor('admin/notifications/markasread/'.$row->id, $row->title, array('target' => '_blank')),
                status_notification($row->status),
                // Ícones de ações
                div(array('class' => 'btn-group btn-group-xs')) .
                anchor('admin/notifications/delete/' . $row->id, glyphicon('trash') ,array('class' => 'btn btn-default', 'data-confirm' => wpn_lang('wpn_message_confirm'))) .
                div(null, true)
            );
        }

        $this->set_var('pagination_links', $this->pagination->create_links());
        $this->set_var('total_rows', $total_rows);
        $this->set_var('listagem', $this->table->generate());
        $this->render();
    }
    
    /**
     * Apaga uma notificação.
     * 
     * @param int $id
     */
    public function delete($id)
    {
        if ($id == null)
            $this->set_message(wpn_lang('wpn_message_inexistent'), 'info', 'admin/notifications');
        if ($this->notification->delete($id))
            $this->set_message(wpn_lang('wpn_message_delete_success'), 'success', 'admin/notifications');
        else
            $this->set_message(wpn_lang('wpn_message_delete_error'), 'danger', 'admin/notifications');
    }
    
    /**
     * Marca a notificação como lida e redireciona para o link.
     * 
     * @param int $id
     */
    public function markasread($id)
    {
        $query = $this->notification->find($id);
        $this->notification->update($id, array('status' => 1));
        redirect('http://wpanel.org/post/'.$query->url);
    }
}
