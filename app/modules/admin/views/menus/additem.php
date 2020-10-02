<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/menus'); ?>"><i class="fa fa-reorder"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_add_item'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_add_item'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open('admin/menus/additem/' . $menu_id, array('role'=>'form')); ?>
                <div class="form-group">
                    <label for="label"><?= wpn_lang('field_label'); ?></label>
                    <input type="text" name="label" id="label" class="form-control" />
                    <?= form_error('label'); ?>
                </div>
                <div class="form-group">
                    <p><label for="tipo"><?= wpn_lang('field_type'); ?></label></p>
                    <div class="radio">
                        <label id="tipo_link">
                            <input type="radio" name="tipo" id="tipo_link" value="link" checked="checked" />
                            <?= wpn_lang('opt_external_link'); ?>
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_post" value="post" />
                            <?= wpn_lang('opt_page_post'); ?>
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_posts" value="posts" />
                            <?= wpn_lang('opt_post_list'); ?>
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_funcional" value="funcional" />
                            <?= wpn_lang('opt_functional'); ?>
                        </label>
                        <label>
                            <input type="radio" name="tipo" id="tipo_submenu" value="submenu" />
                            <?= wpn_lang('opt_submenu'); ?>
                        </label>
                    </div>
                    <?= form_error('tipo'); ?>
                </div>
                <div class="form-group" id="form_link">
                    <label for="link"><?= wpn_lang('field_link'); ?></label>
                    <input type="text" name="link" id="link" class="form-control" />
                    <?= form_error('link'); ?>
                </div>
                <div class="form-group" id="form_post" style="display: none;">
                    <label for="post_id"><?= wpn_lang('opt_page_post'); ?></label>
                    <select class="form-control" name="post_id" id="post_id">
                        <?php
                        foreach ($posts as $row_post)
                        {
                            echo '<option value="' . $row_post->link . '">' . $row_post->title . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="form_posts" style="display: none;">
                    <label for="categoria_id"><?= wpn_lang('opt_post_list'); ?></label>
                    <select class="form-control" name="categoria_id" id="categoria_id">
                        <?php
                        foreach ($categorias as $row_cat)
                        {
                            echo '<option value="' . $row_cat->id . '">' . $row_cat->title . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="form_funcional" style="display: none;">
                    <label for="funcional"><?= wpn_lang('opt_functional'); ?></label>
                    <select class="form-control" name="funcional" id="funcional">
                        <?php foreach(config_item('funcional_links') as $key => $value){ ?>
                            <option value="<?= $key; ?>"><?= $value ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group" id="form_submenu" style="display: none;">
                    <label for="funcional"><?= wpn_lang('opt_submenu'); ?></label>
                    <select class="form-control" name="submenu" id="funcional">
                        <option value=""><?= wpn_lang('wpn_select'); ?></option>
                        <?php foreach($menus as $row_menu){ ?>
                        <option value="<?= $row_menu->id; ?>"><?= $row_menu->nome; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ordem"><?= wpn_lang('field_order'); ?></label>
                            <input type="text" name="ordem" id="ordem" class="form-control" />
                            <?= form_error('ordem'); ?>
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
                            <?= form_dropdown('target', $options_target, null, array('class'=>'form-control')); ?>
                            <?= form_error('target'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                    <?= anchor('admin/menus', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                </div>
            </form>
        </div>
    </div>
</section>