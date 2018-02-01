<?php
// Captura o avatar do usuário.
$avatar = auth_extra_data('avatar');
if ($avatar)
    $avatar = base_url('media/avatar') . '/' . $avatar;
else
    $avatar = base_url('lib/img') . '/no-user.jpg';
?>
<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('dash_welcome'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <?= wpn_lang('module_title'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 col-sm-3 hidden-xs">
                    <img src="<?= $avatar; ?>" class="img-responsive img-thumbnail" alt="<?= auth_extra_data('name'); ?>"/>
                </div>
                <div class="col-md-4 col-sm-4">
                    <h2><?= wpn_lang('dash_hello'); ?> <?= auth_extra_data('name'); ?>.</h2>
                    <p><?= auth_extra_data('name'); ?> - <?= auth_login_data('email'); ?></p>
                    <p><?= wpn_lang('dash_since'); ?> <?= mdate(config_item('user_date_format'), strtotime(auth_login_data('created_on'))); ?></p>
                    <p><?= anchor('admin/accounts/profile', wpn_lang('dash_link_manageprofile'), array('class' => 'btn btn-primary')); ?></p>
                </div>
                <div class="col-md-5 col-sm-5">
                    <h4><?= wpn_lang('dash_summary'); ?></h4>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><?= wpn_lang('dash_summary_post'); ?></td>
                                <td><?php echo badge($total_posts); ?></td>
                            </tr>
                            <tr>
                                <td><?= wpn_lang('dash_summary_page'); ?></td>
                                <td><?php echo badge($total_paginas); ?></td>
                            </tr>
                            <tr>
                                <td><?= wpn_lang('dash_summary_banner'); ?></td>
                                <td><?php echo badge($total_banners); ?></td>
                            </tr>
                            <tr>
                                <td><?= wpn_lang('dash_summary_event'); ?></td>
                                <td><?php echo badge($total_agendas); ?></td>
                            </tr>
                            <tr>
                                <td><?= wpn_lang('dash_summary_gallery'); ?></td>
                                <td><?php echo badge($total_albuns); ?></td>
                            </tr>
                            <tr>
                                <td><?= wpn_lang('dash_summary_video'); ?></td>
                                <td><?php echo badge($total_videos); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" style="margin-top:10px;">
                    <a 
                        href="<?= site_url('admin/posts'); ?>" 
                        class="btn btn-primary btn-lg btn-block" 
                        style="padding-top:30px;padding-bottom:30px;">
                        <span class="glyphicon glyphicon-list-alt"></span> <?= wpn_lang('dash_manage_posts'); ?>
                    </a>
                </div>
                <div class="col-md-4" style="margin-top:10px;">
                    <a 
                        href="<?= site_url('admin/pages'); ?>" 
                        class="btn btn-primary btn-lg btn-block" 
                        style="padding-top:30px;padding-bottom:30px;">
                        <span class="glyphicon glyphicon-list-alt"></span> <?= wpn_lang('dash_manage_pages'); ?>
                    </a>
                </div>
                <div class="col-md-4" style="margin-top:10px;">
                    <a 
                        href="<?= site_url('admin/banners'); ?>" 
                        class="btn btn-primary btn-lg btn-block" 
                        style="padding-top:30px;padding-bottom:30px;">
                        <span class="glyphicon glyphicon-align-justify"></span> <?= wpn_lang('dash_manage_banners'); ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" style="margin-top:10px;">
                    <a 
                        href="<?= site_url('admin/accounts'); ?>"
                        class="btn btn-primary btn-lg btn-block" 
                        style="padding-top:30px;padding-bottom:30px;">
                        <span class="glyphicon glyphicon-user"></span> <?= wpn_lang('dash_manage_accounts'); ?>
                    </a>
                </div>
                <div class="col-md-4" style="margin-top:10px;">
                    <a 
                        href="<?= site_url('admin/configuracoes'); ?>" 
                        class="btn btn-primary btn-lg btn-block" 
                        style="padding-top:30px;padding-bottom:30px;">
                        <span class="glyphicon glyphicon-cog"></span> <?= wpn_lang('dash_configurations'); ?>
                    </a>
                </div>
                <div class="col-md-4" style="margin-top:10px;">
                    <a 
                        href="<?= site_url(); ?>" target="_blank" 
                        class="btn btn-primary btn-lg btn-block" 
                        style="padding-top:30px;padding-bottom:30px;">
                        <span class="glyphicon glyphicon-globe"></span> <?= wpn_lang('dash_view_site'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>