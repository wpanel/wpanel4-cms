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
        <h1 class="page-header"><?= wpn_lang('newsletter_page_title'); ?></h1>
        <p><?= wpn_lang('newsletter_page_message'); ?></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= form_open('newsletter', array('role' => 'form')); ?>
        <div class="form-group">
            <label class="control-label" for="nome"><?= wpn_lang('input_name'); ?></label>
            <input class="form-control" name="nome" value="<?= set_value('nome'); ?>" id="nome" placeholder="<?= wpn_lang('input_name_placeholder'); ?>" type="text">
            <?php echo form_error('nome'); ?>
        </div>
        <div class="form-group">
            <label class="control-label" for="email"><?= wpn_lang('input_email'); ?></label>
            <input class="form-control" name="email" value="<?= set_value('email'); ?>" id="email" placeholder="<?= wpn_lang('input_email_placeholder'); ?>" type="text">
            <?php echo form_error('email'); ?>
        </div>
        <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-envelope"></span> <?= wpn_lang('input_submit'); ?>
        </button>
        <?= form_close(); ?>
    </div>
</div>