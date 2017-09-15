<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/categorias'); ?>"><i class="fa fa-tag"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_add'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_add'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open('admin/categorias/add', array('role'=>'form')); ?>
                <div class="form-group" >
                    <label for="title"><?= wpn_lang('field_title'); ?></label>
                    <input type="text" name="title" value="" class="form-control"  />
                    <?= form_error('title'); ?>
                </div>
                <div class="form-group" >
                    <label for="description"><?= wpn_lang('field_description'); ?></label>
                    <textarea name="description" cols="40" rows="10" class="form-control" ></textarea>
                </div>
                <div class="row " id="">
                    <div class="col-md-6 " id="">
                        <div class="form-group" >
                            <label for="category_id"><?= wpn_lang('field_category'); ?></label>
                            <?= form_dropdown('category_id', $options, '', array('class'=>'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-md-6 " id="">
                        <div class="form-group" >
                            <label for="view"><?= wpn_lang('field_view'); ?></label>
                            <?php
                            $options = config_item('posts_views');
                            echo form_dropdown('view', $options, '', array('class'=>'form-control'));
                            ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                <?= anchor('admin/categorias', wpn_lang('wpn_bot_cancel'), array('class'=>'btn btn-danger')); ?>
            <?= form_close(); ?>
            <?php
            /*
              echo form_open('admin/categorias/add', array('role'=>'form'));

              echo div(array('class'=>'form-group'));
              echo form_label('Título', 'title');
              echo form_input(array('name'=>'title', 'value'=> set_value('name'), 'class'=>'form-control'));
              echo form_error('title');
              echo div(null, true);

              echo div(array('class'=>'form-group'));
              echo form_label('Descrição', 'description');
              echo form_textarea(array('name'=>'description', 'class'=>'form-control'));
              echo div(null, true);

              echo row();
              echo col(6);

              echo div(array('class'=>'form-group'));
              echo form_label('Categoria-pai', 'category_id');
              echo form_dropdown('category_id', $options, '', array('class'=>'form-control'));

              echo close_div(2);
              echo col(6);

              $options = config_item('posts_views');

              echo div(array('class'=>'form-group'));
              echo form_label('Tipo de visualização', 'view');
              echo form_dropdown('view', $options, '', array('class'=>'form-control'));

              echo close_div(3);


              echo form_button(array('type'=>'submit', 'name'=>'submit', 'content'=>'Cadastrar', 'class'=>'btn btn-primary'));
              echo '&nbsp;';
              echo anchor('admin/categorias', 'Cancelar', array('class'=>'btn btn-danger'));

              echo form_close();
             */
            ?>
        </div>
    </div>
</section>