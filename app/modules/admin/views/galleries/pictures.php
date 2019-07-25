<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>
        <?= wpn_lang('submodule_title'); ?>
        <small><?= wpn_lang('submodule_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/galleries'); ?>"><i class="fa fa-camera"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('submodule_title'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('submodule_index'); ?></h3>
            <div class="box-tools pull-right">
                <?= anchor('admin/galleries', glyphicon('chevron-left') . wpn_lang('wpn_bot_back'), array('class' => 'btn btn-sm btn-primary')); ?>
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addsinglepicture">
                    <?= glyphicon('plus-sign'); ?> <?= wpn_lang('bot_individual_upload'); ?>
                </button>
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addmasspicture">
                    <?= glyphicon('plus-sign'); ?> <?= wpn_lang('bot_mass_upload'); ?>
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

<!--Modal addsinglepicture-->
<?= form_open_multipart('admin/galleries/addpicture/'.$album_id, array('role'=>'form')); ?>
<div class="modal fade" id="addsinglepicture" tabindex="-1" role="dialog" aria-labelledby="addsinglepicture">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= wpn_lang('title_individual_upload'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?= wpn_lang('field_filename'); ?></label>
                    <input type="file" name="userfile" class="form-control" />
                </div>
                <div class="form-group">
                    <label><?= wpn_lang('field_description'); ?></label>
                    <input type="text" name="descricao" value="<?= set_value('descricao'); ?>" class="form-control" />
                    <?= form_error('descricao'); ?>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <label><?= wpn_lang('field_status'); ?></label>
                            <select class="form-control" name="status">
                                <option value="0">Indisponível</option>
                                <option value="1">Publicado</option>
                            </select>
                        </div>
                    </div>
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

<!--Modal addmasspicture-->
<?= form_open_multipart('admin/galleries/addmass/' . $album_id, array('role' => 'form')); ?>
<div class="modal fade" id="addmasspicture" tabindex="-1" role="dialog" aria-labelledby="addmasspicture">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= wpn_lang('title_mass_upload'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?= wpn_lang('field_mass_files'); ?></label>
                    <input type="file" name="pictures[]" multiple="multiple" class="form-control" />
                    <?= form_error('pictures'); ?>
                </div>
                <div class="form-group">
                    <label><?= wpn_lang('field_description'); ?></label>
                    <input type="text" name="descricao" value="<?= set_value('descricao'); ?>" class="form-control" />
                    <?= form_error('descricao'); ?>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <label><?= wpn_lang('field_status'); ?></label>
                            <select name="status" class="form-control">
                                <option value="0">Indisponível</option>
                                <option value="1">Publicado</option>
                            </select>
                        </div>
                    </div>
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