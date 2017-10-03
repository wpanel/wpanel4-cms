<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>
        <?= wpn_lang('module_title') ?>
        <small><?= wpn_lang('module_description') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard') ?></a></li>
        <li><i class="fa fa-cog"></i> <?= anchor('admin/developers', wpn_lang('module_title')); ?></li>
        <li><i class="fa fa-cog"></i> <?= wpn_lang('module_backup_list') ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_backup_list') ?></h3>
            <div class="box-tools pull-right">
                <?php 
                if($compatible)
                    echo anchor('admin/developers/backups/1', glyphicon('plus-sign') . wpn_lang('wpn_bot_new'), array('class' => 'btn btn-sm btn-primary')); 
                else
                    echo '<span class="text-danger">'.wpn_lang('msg_compatibility').'</span>';
                ?>
            </div>
        </div>
        <div class="box-body">
            
            <div class="table-responsive">
                <div class="container-fluid">
                    <?= $listagem; ?>
                </div>
            </div>
 
        </div>
    </div>
</section>
