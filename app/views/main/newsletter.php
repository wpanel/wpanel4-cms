<?php
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
    <div class="col-md-6">
        <h1>Newsletter</h1>
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