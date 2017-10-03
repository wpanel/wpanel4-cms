<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><i class="fa fa-cog"></i> <?= wpn_lang('module_title'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_index'); ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><?= glyphicon('plus-sign') . wpn_lang('wpn_bot_new') ?></button>
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

<!-- Modal Novo Modulo -->
<?= form_open('admin/modulos/add'); ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= wpn_lang('module_add'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id" class="col-sm-3 col-md-3 control-label"><?= wpn_lang('field_name'); ?></label>
                    <div class="col-sm-9 col-md-9">
                        <input type="text" name="name" id="name" class="form-control" />
                        <?= form_error('name'); ?>
                    </div>
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