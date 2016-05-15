<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        <?= wpn_lang('mod_post', 'Posts'); ?>
        <small><?= wpn_lang('desc_post', 'Manage articles and post of the site.'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('mod_dashboard', 'Dashboard'); ?></a></li>
        <li><i class="fa fa-files-o"></i> <?= wpn_lang('mod_post', 'Posts'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('pan_post', 'Posts list'); ?></h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/posts/add', glyphicon('plus-sign') . wpn_lang('bot_new', 'New record'), array('class' => 'btn btn-sm btn-primary')); ?>
                <?= anchor('admin/categorias', glyphicon('th-list') . wpn_lang('bot_category', 'Categories'), array('class' => 'btn btn-sm btn-default')); ?>
            </div>
        </div>
        <div class="box-body">
            <?= $listagem; ?>
        </div>
    </div>
</section>