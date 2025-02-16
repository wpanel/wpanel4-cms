<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><?= wpn_lang('contact_page_title'); ?></h1>
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
                    <label for="nome" class="control-label"><?= wpn_lang('input_name'); ?> <b>(*)</b></label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nome" id="nome" value="<?= set_value('nome'); ?>" placeholder="<?= wpn_lang('input_name_placeholder'); ?>">
                    <?= form_error('nome'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="email" class="control-label"><?= wpn_lang('input_email'); ?> <b>(*)</b></label>
                </div>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email'); ?>" placeholder="<?= wpn_lang('input_email_placeholder'); ?>">
                    <?= form_error('email'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="telefone" class="control-label"><?= wpn_lang('input_phone'); ?></label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="telefone" id="telefone" placeholder="<?= wpn_lang('input_phone_placeholder'); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="mensagem" class="control-label"><?= wpn_lang('input_message'); ?> <b>(*)</b></label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" name="mensagem" id="mensagem" rows="8"><?= set_value('mensagem'); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?= $captcha; ?>
                    <?= wpn_lang('input_captcha_challenge'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label for="captcha" class="control-label"><?= wpn_lang('input_confirmation'); ?></label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="captcha" id="captcha" placeholder="<?= wpn_lang('input_confirmation_placeholder'); ?>">
                    <?= form_error('captcha'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary"><?= wpn_lang('input_send'); ?></button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>