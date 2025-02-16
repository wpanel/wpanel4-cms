<h1 class="page-header"><?= wpn_lang('users_password_recovery_title'); ?></h1>
<p><?= wpn_lang('users_password_recovery_title_message'); ?></p>
<?= form_open('users/recovery'); ?>
<div class="row">
    <div class="col-sm-4 col-md-4">
        <div class="form-group">
            <label><?= wpn_lang('input_email'); ?></label>
            <input type="text" name="email" class="form-control" placeholder="<?= wpn_lang('input_email_placeholder'); ?>" />
            <?= form_error('email'); ?>
        </div>
        <button type="submit" class="btn btn-primary"><?= wpn_lang('input_submit'); ?></button>
        <?= anchor('users/login', wpn_lang('input_back'), array('class' => 'btn btn-danger')); ?>
    </div>
</div>
<?= form_close(); ?>