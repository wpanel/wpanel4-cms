<h1 class="page-header"><?= wpn_lang('users_activation_title_success') ?></h1>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <p><?= wpn_lang('users_activation_message_line_1'); ?></p>
        <p><?= wpn_lang('users_activation_message_line_2'); ?></p>
        <hr/>
        <p>
            <?= anchor('', wpn_lang('link_home'), array('class' => 'btn btn-success')); ?>
            <?= anchor('users/login', wpn_lang('link_login'), array('class' => 'btn btn-info')); ?>
        </p>
    </div>
</div>