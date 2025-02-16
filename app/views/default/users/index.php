<h1 class="page-header"><?= wpn_lang('users_dashboard_title'); ?></h1>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><?= anchor('users', wpn_lang('users_dashboard')); ?></li>
            <li role="presentation"><?= anchor('users/profile', wpn_lang('users_account_profile')); ?></li>
            <li role="presentation"><?= anchor('users/logout', wpn_lang('users_logout')); ?></li>
        </ul>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <p><?= wpn_lang('users_dashboard_message'); ?></p>
    </div>
</div>