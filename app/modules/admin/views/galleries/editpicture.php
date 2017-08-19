<section class="content-header">
    <h1>
        <?= wpn_lang('submodule_title'); ?>
        <small><?= wpn_lang('submodule_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/galleries'); ?>"><i class="fa fa-camera"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('submodule_edit'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('submodule_edit'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/galleries/editpicture/' . $row->id, array('role' => 'form')); ?>
            <div class="form-group">
                <label><?= wpn_lang('field_filename'); ?></label>
                <input type="file" name="userfile" class="form-control" />
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="alterar_imagem" value="1" />
                    <?= wpn_lang('change_image'); ?>
                </label>
            </div>
            <?php
            $data = array(
                'src' => 'media/albuns/' . $row->album_id . '/' . $row->filename,
                'class' => 'img-responsive img-thumbnail',
                'style' => 'margin-top:5px;'
            );
            echo img($data);
            ?>
            <div class="form-group">
                <label><?= wpn_lang('field_description'); ?></label>
                <input type="text" name="descricao" value="<?= $row->descricao; ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label><?= wpn_lang('field_status'); ?></label>
                <select name="status" class="form-control">
                    <option value="0" <?php if ($row->status == 0) {
                        echo 'selected';
                    } ?> >Indisponível</option>
                    <option value="1" <?php if ($row->status == 1) {
                        echo 'selected';
                    } ?> >Publicado</option>
                </select>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                    &nbsp; <?= anchor('admin/galleries/pictures/' . $row->album_id, wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>