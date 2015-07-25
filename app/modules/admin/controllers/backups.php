<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backups extends MX_Controller {

	function __construct()
	{
		$this->auth->protect('admin');
		$this->form_validation->set_error_delimiters('<p><span class="label label-danger">', '</span></p>');
	}

	public function index()
	{
		redirect('admin');
	}

	public function execute()
	{

		$filename = 'wpanel-backup-' . date('d-m-Y-H-i-s') . '.sql';

		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$prefs = array(
                'format'      => 'zip',
                'filename'    => $filename,
                'add_drop'    => TRUE,
                'add_insert'  => TRUE,
                'newline'     => "\n"
        );

		$backup =& $this->dbutil->backup($prefs);

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('/media/' . $filename . '.zip', $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($filename . '.zip', $backup); 
	}

}