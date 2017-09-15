<?php
echo $this->wpanel->load_editor();
?>
<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/posts'); ?>"><i class="fa fa-files-o"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_add'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_add'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/posts/add', array('role' => 'form')); ?>
                <div class="form-group" >
                    <label for="title"><?= wpn_lang('field_title'); ?></label>
                    <input type="text" name="title" value="" class="form-control" />
                    <?= form_error('title'); ?>
                </div>
                <div class="form-group" >
                    <label for="description"><?= wpn_lang('field_description'); ?></label>
                    <textarea name="description" cols="40" rows="3" class="form-control" ></textarea>
                </div>
                <div class="form-group" >
                    <label for="content"><?= wpn_lang('field_content'); ?></label>
                    <textarea name="content" cols="40" rows="10" class="form-control" id="editor" ></textarea>
                </div>
                <div class="row " id="">
                    <div class="col-md-3 " id="">
                        <div class="form-group" >
                            <label for="userfile"><?= wpn_lang('field_folder'); ?></label>
                            <input type="file" name="userfile" value="" class="form-control"  />
                        </div>
                    </div>
                    <div class="col-md-3 " id="">
                        <div class="form-group" >
                            <label for="category_id"><?= wpn_lang('field_category'); ?></label>
                            <?= form_multiselect('category_id[]', $categorias, null, array('class' => 'form-control')); ?>
                            <?= anchor('admin/categorias', glyphicon('share') . ' ' . wpn_lang('post_bot_new_category'), array('class' => 'btn btn-xs btn-primary')); ?>
                        </div>
                    </div>
                    <div class="col-md-3 " id="">
                        <div class="form-group" >
                            <label for="tags"><?= wpn_lang('field_tags'); ?></label>
                            <textarea name="tags" cols="40" rows="4" class="form-control" ></textarea>
                            <span class="text-sm"><?= wpn_lang('use_comma'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3 " id="">
                        <div class="form-group" >
                            <label for="status"><?= wpn_lang('field_status'); ?></label>
                            <?php
                            // Opções de status
                            $options = array(
                                '0' => 'Rascunho',
                                '1' => 'Publicado'
                            );
                            echo form_dropdown('status', $options, null, array('class' => 'form-control'));
                            ?>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row " id="">
                    <div class="col-md-12 " id="">
                        <?= form_button(array( 'type' => 'submit', 'name' => 'submit', 'content' => wpn_lang('wpn_bot_save'), 'class' => 'btn btn-primary')); ?>
                        <?= anchor('admin/posts', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>