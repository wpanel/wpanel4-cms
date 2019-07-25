<section class="content-header">
    <h1>
        <?= wpn_lang('submodule_title'); ?>
        <small><?= wpn_lang('submodule_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/galleries'); ?>"><i class="fa fa-camera"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('submodule_add'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('title_individual_upload'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/galleries/addpicture/'.$album_id, array('role'=>'form')); ?>
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
            <hr/>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                    &nbsp; <?= anchor('admin/galleries/pictures/'.$album_id, wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>