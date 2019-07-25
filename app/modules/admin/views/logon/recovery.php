<div class="login-box">
    <div class="login-logo">
        <b>Admin</b>WPanel
    </div>
    <div class="login-box-body">
        <?php
        $msg_sistema = $this->session->flashdata('msg_recover');
        if ($msg_sistema)
            echo alerts($msg_sistema, 'warning', true);
        echo form_open('admin/recovery', array('role' => 'form'));
        ?>
        <div class="row">
            <div class="col-md-12">
                <p><?= wpn_lang('logon_recovery_instructions'); ?></p>
            </div>
        </div>
        <div class="form-group has-feedback">
            <input class="form-control" id="email" name="email" autofocus="autofocus" placeholder="<?= wpn_lang('logon_email'); ?>" type="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <?= form_error('email'); ?>
        </div>
        <div class="row">
            <div class="col-xs-8">&nbsp;&nbsp;<?= anchor('admin/login', wpn_lang('logon_link_back')); ?></div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat"><?= wpn_lang('logon_bot_recovery'); ?></button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
    <p class="text-center" style="padding-top:20px;">&copy; <?php echo date('Y') ?> <a href="http://wpanel.org" target="_blank">Wpanel CMS</a>. <?= wpn_lang('wpn_copyright'); ?>.</p>
</div>
