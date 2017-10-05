<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/galleries'); ?>"><i class="fa fa-camera"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_edit'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/galleries/edit/' . $row->id, array('role' => 'form')); ?>
            <div class="form-group">
                <label for="titulo"><?= wpn_lang('field_title'); ?></label>
                <input type="text" name="titulo" value="<?= $row->titulo; ?>" class="form-control" />
                <?= form_error('titulo'); ?>
            </div>
            <div class="form-group">
                <label for="descricao"><?= wpn_lang('field_description'); ?></label>
                <textarea name="descricao" rows="5" class="form-control"><?= $row->descricao; ?></textarea>
                <?= form_error('descricao'); ?>
            </div>
            <div class="form-group">
                <label for="tags"><?= wpn_lang('field_tags'); ?></label>
                <input type="text" name="tags" value="<?= $row->tags; ?>" class="form-control" />
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        <label for="userfile"><?= wpn_lang('field_folder'); ?></label>
                        <input type="file" name="userfile" class="form-control" />
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="alterar_imagem" value="1" />
                                <?= wpn_lang('change_image'); ?>
                            </label>
                        </div>
                        <?php
                        $data = array(
                            'src' => 'media/capas/' . $row->capa,
                            'class' => 'img-responsive img-thumbnail',
                            'style' => 'margin-top:5px;'
                        );
                        echo img($data);
                        ?>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="form-group">
                        <label for="status"><?= wpn_lang('field_status'); ?></label>
                        <select name="status" class="form-control">
                            <option value="0" <?php if ($row->status == 0) {
                            echo 'selected';
                        } ?>>Indisponível</option>
                            <option value="1" <?php if ($row->status == 1) {
                            echo 'selected';
                        } ?>>Publicado</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                    &nbsp;<?= anchor('admin/galleries', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
<?= form_close(); ?>
        </div>
    </div>
</section>