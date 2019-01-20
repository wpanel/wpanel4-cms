<div class="login-box">
    <div class="login-logo">
        <b>Admin</b>WPanel
    </div>
    <div class="login-box-body">
        <p class="login-box-msg"><?= wpn_lang('logon_message'); ?></p>
        <?php
        $msg_sistema = $this->session->flashdata('msg_auth');
        if ($msg_sistema)
            echo alerts($msg_sistema, 'warning', true);
        echo form_open('admin/login', array('role' => 'form'));
        ?>
        <div class="form-group has-feedback">
            <input type="text" name="email" class="form-control" autofocus="autofocus" placeholder="<?= wpn_lang('logon_email'); ?>"/>
            <?= form_error('email'); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="<?= wpn_lang('logon_password'); ?>"/>
            <?= form_error('password'); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">       
                <?= anchor('admin/recovery', wpn_lang('logon_link_recovery')); ?>                 
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat"><?= wpn_lang('logon_bot_login'); ?></button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
    <p class="text-center" style="padding-top:20px;">&copy; <?php echo date('Y') ?> <a href="http://wpanel.org" target="_blank">Wpanel CMS</a>. <?= wpn_lang('wpn_copyright'); ?>.</p>
</div>
