<div class="row">
    <div class="col-md-12">
        <h3 class="page-header"><?= wpn_lang('users_registration_title') ?></h3>
    </div>
</div>
<?php
/**
 * Mostra a mensagem de retorno de sucesso ou erro
 * ao enviar a mensagem.
 */
$msg_site = $this->session->flashdata('msg_site');
if($msg_site){
    echo alerts($msg_site, 'warning', true);
}
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <?= form_open('users/register', array('role' => 'form', 'class' => 'form-horizontal',)); ?>
            <div class="form-group">
                <label for="name" id="lb_nome" class="col-sm-3 control-label"><?= wpn_lang('input_name') ?> <b>(*)</b></label>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="form-control"  />
                    <?= form_error('name'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-3 control-label"><?= wpn_lang('input_email') ?> <b>(*)</b></label>
                <div class="col-sm-5">
                    <input type="text" name="email" id="email" class="form-control" />
                    <?= form_error('email'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label"><?= wpn_lang('input_password') ?> <b>(*)</b></label>
                <div class="col-sm-3">
                    <input type="password" name="password" id="password" class="form-control" />
                    <?= form_error('password'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="senha" class="col-sm-3 control-label"><?= wpn_lang('input_password_confirmation') ?> <b>(*)</b></label>
                <div class="col-sm-3">
                    <input type="password" name="confpass" id="confpass" class="form-control" />
                    <?= form_error('confpass'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary" ><?= wpn_lang('input_submit') ?></button>
                    <?= anchor('', wpn_lang('input_cancel'), array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>