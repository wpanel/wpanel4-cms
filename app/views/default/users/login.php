<h1 class="page-header">
    <?= wpn_lang('users_login_title'); ?><br/>
    <small><?= wpn_lang('users_login_message'); ?></small>
</h1>

<div class="row">
    <div class="col-sm-6">
        <?= form_open('users/login', array('class'=>'col-sm-10', 'role'=>'form')); ?>
            <div class="form-group">
                <label for="email"><?= wpn_lang('input_email'); ?></label>
                <input type="text" class="form-control" id="email" name="email" placeholder="<?= wpn_lang('input_email_placeholder'); ?>">
                <?= form_error('email'); ?>
            </div>
            <div class="form-group">
                <label for="password"><?= wpn_lang('input_password'); ?></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="<?= wpn_lang('input_password_placeholder'); ?>">
                <?= form_error('password'); ?>
            </div>
            <div>
                <button type="submit" class="btn btn-primary"><?= wpn_lang('input_submit'); ?></button>
                <?= anchor('users/recovery', wpn_lang('users_forgot_password_link'), array('class' => 'btn btn-link')); ?>
            </div>
        <?= form_close(); ?>
    </div>
    <div class="col-sm-6">
        <h4><?= wpn_lang('users_header_register'); ?></h4>
        <p><?= wpn_lang('users_header_register_message'); ?></p>
        <p><?= anchor('users/register', wpn_lang('users_register_link'), array('class' => 'btn btn-primary')); ?></p>
    </div>
</div>