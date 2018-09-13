<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>
        <?= wpn_lang('module_title') ?>
        <small><?= wpn_lang('module_description') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard') ?></a></li>
        <li><i class="fa fa-cog"></i> <?= anchor('admin/developers', wpn_lang('module_title')); ?></li>
        <li><i class="fa fa-cog"></i> <?= wpn_lang('module_migration_list') ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_migration_list') ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-sm btn-primary btn-lg" data-toggle="modal" data-target="#upload_migration"><?= glyphicon('plus-sign') . wpn_lang('bot_new_migration'); ?></button>
                <?= anchor('admin/developers/lastmigration', glyphicon('refresh') . wpn_lang('bot_update_lastversion'), array('data-confirm' => wpn_lang('msg_confirm_update_lastversion'), 'class' => 'btn btn-sm btn-primary')); ?>
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

<!-- Modal upload -->
<?= form_open_multipart('admin/developers/uploadmigration', array('role' => 'form')); ?>
    <div class="modal fade" id="upload_migration" tabindex="-1" role="dialog" aria-labelledby="upload_migration">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="new_menu"><?= wpn_lang('module_add_migration'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome"><?= wpn_lang('field_nome'); ?></label>
                        <input type="file" name="userfile" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
                    <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?= form_close(); ?>