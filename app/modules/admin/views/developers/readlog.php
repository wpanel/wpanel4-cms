<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>
        <?= wpn_lang('module_title') ?>
        <small><?= wpn_lang('module_description') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard') ?></a></li>
        <li><i class="fa fa-cog"></i> <?= anchor('admin/developers', wpn_lang('module_title')); ?></li>
        <li><i class="fa fa-cog"></i> <?= anchor('admin/developers/logs', wpn_lang('module_log_list')); ?></li>
        <li><i class="fa fa-cog"></i> <?= wpn_lang('module_log_reading') ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_log_reading') ?></h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/developers/logs', glyphicon('chevron-left') . wpn_lang('wpn_bot_back'), array('class' => 'btn btn-sm btn-primary')); ?>
            </div>
        </div>
        <div class="box-body">
            
            <div class="table-responsive">
                <pre><?= $content; ?></pre>
            </div>
            
        </div>
    </div>
</section>
