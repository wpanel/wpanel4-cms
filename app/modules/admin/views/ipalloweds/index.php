<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/accounts'); ?>"><i class="fa fa-users"></i> <?= wpn_lang('wpn_menu_account'); ?></a></li>
        <li><i class="fa fa-cog"></i> <?= wpn_lang('module_title'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_index'); ?></h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/accounts', glyphicon('user') . wpn_lang('wpn_menu_account'), array('class' => 'btn btn-sm btn-info')); ?>
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addIp">
                    <?= glyphicon('plus-sign'); ?> <?= wpn_lang('wpn_bot_new'); ?>
                </button>
            </div>
        </div>
        <div class="box-body">
            
            <div class="table-responsive">
                <div class="container-fluid">
                    <?= $listagem; ?>
                </div>
            </div>
            
            <hr/>

            <div class="row" style="margin-bottom: 20px;">
                <div class="col-sm-12 col-md-12">
                    <span class="total"><?= wpn_lang('pag_total_of'); ?> <b><?= $total_rows; ?></b> <?= wpn_lang('pag_records'); ?>.</span>
                    <nav class="text-center">
                        <?= $pagination_links; ?>
                    </nav>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!--Modal addIp-->
<?= form_open_multipart('admin/ipalloweds/add', array('role'=>'form')); ?>
<div class="modal fade" id="addIp" tabindex="-1" role="dialog" aria-labelledby="addIp">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= wpn_lang('module_add'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?= wpn_lang('field_description'); ?></label>
                    <input type="text" name="description" id="description" class="form-control" />
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?= wpn_lang('field_ip'); ?></label>
                    <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="000.000.000.000" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>