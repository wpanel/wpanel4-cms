<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?= form_open('newsletter', array('role' => 'form')); ?>
    <div class="form-group">
        <label class="control-label" for="nome"><?= wpn_lang('input_name'); ?></label>
        <input class="form-control" name="nome" id="nome" placeholder="<?= wpn_lang('input_name_placeholder'); ?>" type="text">
    </div>
    <div class="form-group">
        <label class="control-label" for="email"><?= wpn_lang('input_email'); ?></label>
        <input class="form-control" name="email" id="email" placeholder="<?= wpn_lang('input_email_placeholder'); ?>" type="text">
    </div>
    <button type="submit" class="btn btn-primary">
        <span class="glyphicon glyphicon-envelope"></span> <?= wpn_lang('input_submit'); ?>
    </button>
<?= form_close(); ?>