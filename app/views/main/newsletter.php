<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<?php

// TODO Remover este aviso e usar o notice padrão do template.

/**
 * Mostra a mensagem de retorno de sucesso ou erro
 * ao enviar o cadastro.
 */
$msg_newsletter = $this->session->flashdata('msg_newsletter');
if ($msg_newsletter) {
    echo alerts($msg_newsletter, 'warning', true);
}
?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Newsletter</h1>
        <p>Cadastre seu email em nossa lista para que você receba todas as nossas novidades em primeira mão!</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= form_open('newsletter', array('role' => 'form')); ?>
        <div class="form-group">
            <label class="control-label" for="nome">Nome</label>
            <input class="form-control" name="nome" value="<?= set_value('nome'); ?>" id="nome" placeholder="Seu nome..." type="text">
            <?php echo form_error('nome'); ?>
        </div>
        <div class="form-group">
            <label class="control-label" for="email">Email</label>
            <input class="form-control" name="email" value="<?= set_value('email'); ?>" id="email" placeholder="Seu email..." type="text">
            <?php echo form_error('email'); ?>
        </div>
        <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-envelope"></span> Enviar
        </button>
        <?= form_close(); ?>
    </div>
</div>