<section class="content-header">
    <h1>
        <?= wpn_lang('module_title') ?>
        <small><?= wpn_lang('module_description') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard') ?></a></li>
        <li><i class="fa fa-shirtsinbulk"></i> <?= wpn_lang('module_title') ?></li>
        <li><?= wpn_lang('module_edit'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/banners/edit/'.$id, array('role'=>'form')); ?>
            <div class="form-group" >
                <label for="title"><?= wpn_lang('field_title'); ?></label>
                <input type="text" name="title" value="<?= $row->title; ?>" class="form-control"  />
                <?= form_error('title'); ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" >
                        <label for="href"><?= wpn_lang('field_href'); ?></label>
                        <input type="text" name="href" value="<?= $row->href; ?>" class="form-control"  />
                        <?= form_error('href'); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" >
                        <label for="target"><?= wpn_lang('field_target'); ?></label>
                        <?php
                        $options_target = array(
                            '_self'  => wpn_lang('placeholder_target_self'),
                            '_blank'  => wpn_lang('placeholder_target_blank')
                        );
                        ?>
                        <?= form_dropdown('target', $options_target, $row->target, array('class'=>'form-control')); ?>
                        <?= form_error('target'); ?>
                    </div>
                </div>
            </div>
            <div class="row " id="">
                <div class="col-md-2 " id="">
                    <div class="form-group" >
                        <label for="sequence"><?= wpn_lang('field_sequence'); ?></label>
                        <input type="text" name="sequence" value="<?= $row->sequence; ?>" class="form-control"  />
                        <?= form_error('sequence'); ?>
                    </div>
                </div>
                <div class="col-md-2 " id="">
                    <div class="form-group" >
                        <label for="position"><?= wpn_lang('field_position'); ?></label>
                        <?= form_dropdown('position', $options, $row->position, array('class'=>'form-control')); ?>
                    </div>
                    <?= form_error('position'); ?>
                </div>
                <div class="col-md-3 " id="">
                    <div class="form-group" >
                        <label for="status"><?= wpn_lang('field_status'); ?></label>
                        <?php
                        $options = array(
                            '0'  => wpn_lang('wpn_inactive'),
                            '1'  => wpn_lang('wpn_active')
                        );
                        ?>
                        <?= form_dropdown('status', $options, $row->status, array('class'=>'form-control')); ?>
                    </div>
                </div>
            </div>
            <div class="form-group" >
                <label for="userfile">Imagem do banner</label>
                <input type="file" name="userfile" value="" class="form-control"  />
                <hr/>
                <?= img(array('src'=>'media/banners/'.$row->content, 'class'=>'img-responsive img-thumbnail', 'style'=>'margin-top:5px;')); ?>
                <div class="checkbox" >
                    <label>
                        <input type="checkbox" name="alterar_imagem" value="1" class="checkbox"  />
                        <?= wpn_lang('change_image'); ?>
                    </label>
                </div>
                <hr/>
                <div class="row " id="">
                    <div class="col-md-12 " id="">
                        <button name="submit" type="submit" class="btn btn-primary" ><?= wpn_lang('wpn_bot_save'); ?></button>
                        <?= anchor('admin/banners', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>