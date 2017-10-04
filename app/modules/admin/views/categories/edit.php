<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/categories'); ?>"><i class="fa fa-tag"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_edit'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open('admin/categories/edit/'.$row->id, array('role'=>'form')); ?>
                <div class="form-group" >
                    <label for="title"><?= wpn_lang('field_title'); ?></label>
                    <input type="text" name="title" value="<?= $row->title; ?>" class="form-control"  />
                    <?= form_error('title'); ?>
                </div>
                <div class="form-group" >
                    <label for="description"><?= wpn_lang('field_description'); ?></label>
                    <textarea name="description" cols="40" rows="10" class="form-control" ><?= $row->description; ?></textarea>
                </div>
                <div class="row " id="">
                    <div class="col-md-6 " id="">
                        <div class="form-group" >
                            <label for="category_id"><?= wpn_lang('field_category'); ?></label>
                            <?= form_dropdown('category_id', $options, array($row->category_id), array('class'=>'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-md-6 " id="">
                        <div class="form-group" >
                            <label for="view"><?= wpn_lang('field_view'); ?></label>
                            <?php
                            $options = config_item('posts_views');
                            echo form_dropdown('view', $options, array($row->view), array('class'=>'form-control'));
                            ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                <?= anchor('admin/categories', wpn_lang('wpn_bot_cancel'), array('class'=>'btn btn-danger')); ?>
            <?= form_close(); ?>
        </div>
    </div>
</section>