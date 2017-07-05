<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('theme/header');

if (isset($notice)) {
    echo $notice;
}

echo $view_content;

$this->load->view('theme/footer'); 

?>