<section class="content-header">
    <h1>
        <?= wpn_lang('module_title') ?>
        <small><?= wpn_lang('module_description') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard') ?></a></li>
        <li><a href="<?= site_url('admin/videos'); ?>"><i class="fa fa-tag"></i> <?= wpn_lang('module_title') ?></a></li>
        <li><?= wpn_lang('module_edit') ?></li>
    </ol>
</section>
<section class="content">
    <div class="panel panel-default">
        <div class="panel-heading"><?= wpn_lang('module_edit') ?></div>
        <div class="panel-body">
            <?= form_open('admin/videos/edit/' . $row->id, array('class' => 'form-horizontal', 'role' => 'form')); ?>
            <div class="form-group">
                <label for="titulo" class="col-sm-2 col-md-2"><?= wpn_lang('field_title') ?></label>
                <div class="col-sm-10 col-md-10">
                    <input type="text"  class="form-control" id="titulo" name="titulo" value="<?= $row->titulo; ?>" >
                    <?= form_error('titulo'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="descricao" class="col-sm-2 col-md-2"><?= wpn_lang('field_description') ?></label>
                <div class="col-sm-10 col-md-10">
                    <textarea class="form-control" id="descricao" name="descricao"  rows=""><?= $row->descricao; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="tags" class="col-sm-2 col-md-2"><?= wpn_lang('field_tags') ?></label>
                <div class="col-sm-10 col-md-10">
                    <input type="text"  class="form-control" id="tags" name="tags" value="<?= $row->tags; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="link" class="col-sm-2 col-md-2"><?= wpn_lang('field_link') ?></label>
                <div class="col-sm-6 col-md-6">
                    <input type="text"  class="form-control" id="link" name="link" value="https://www.youtube.com/watch?v=<?= $row->link; ?>" >
                    <p class="text-muted"><em>Ex: https://www.youtube.com/watch?v=gLBxGhpy_eQ</em></p>
                    <?= form_error('link'); ?>
                </div>
            </div>
            <div class="form-group">
                <?php
                // Status do usuário
                $options = array(
                    '0' => 'Indisponível',
                    '1' => 'Publicado'
                );
                ?>
                <label for="status" class="col-sm-2 col-md-2"><?= wpn_lang('field_status') ?></label>
                <div class="col-sm-3 col-md-3">
                    <?= form_dropdown('status', $options, array($row->status), array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-md-10 col-sm-offset-2 col-md-offset-2">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $row->link; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <hr/>
            <div class="col-sm-10 col-md-10 col-sm-offset-2 col-md-offset-2">
                <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save') ?></button>
                <?= anchor('admin/videos', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>
