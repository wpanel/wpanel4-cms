<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Fale conosco</h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-offset-2 col-md-10">
        <?= $contact_content; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= form_open('contact', array('class'=>'form-horizontal', 'role'=>'form')); ?>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="nome" class="control-label">Nome <b>(*)</b></label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nome" id="nome" value="<?= set_value('nome'); ?>" placeholder="Seu nome...">
                    <?= form_error('nome'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="email" class="control-label">Email <b>(*)</b></label>
                </div>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email'); ?>" placeholder="Seu email...">
                    <?= form_error('email'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="telefone" class="control-label">Telefone</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Seu telefone...">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="mensagem" class="control-label">Mensagem <b>(*)</b></label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" name="mensagem" id="mensagem" rows="8"><?= set_value('mensagem'); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?= $captcha; ?>
                    Digite o que voce está lendo na imagem no campo abaixo.
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="captcha" class="control-label">Confirmação</label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Texto de confirmação...">
                    <?= form_error('captcha'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Enviar a mensagem</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>