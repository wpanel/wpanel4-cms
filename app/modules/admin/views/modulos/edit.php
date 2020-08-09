<section class="content-header">
    <h1>
        <?= wpn_lang('module_title'); ?>
        <small><?= wpn_lang('module_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><a href="<?= site_url('admin/modulos'); ?>"><i class="fa fa-cog"></i> <?= wpn_lang('module_title'); ?></a></li>
        <li><?= wpn_lang('module_edit'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('module_edit'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open('admin/modulos/edit/' . $row->id, ['role' => 'form', 'class' => 'form-horizontal']); ?>
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_name'); ?></label>
                    <div class="col-sm-10 col-md-10">
                        <input type="text" name="name" id="name" value="<?= $row->name; ?>" class="form-control" />
                        <?= form_error('name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_description'); ?></label>
                    <div class="col-sm-10 col-md-10">
                        <textarea name="description" class="form-control"><?= $row->description; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="author_name" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_author_name'); ?></label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" name="author_name" id="name" value="<?= $row->author_name; ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="author_email" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_author_email'); ?></label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" name="author_email" id="author_email" value="<?= $row->author_email; ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="author_website" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_author_website'); ?></label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" name="author_website" id="author_website" value="<?= $row->author_website; ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="version" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_version'); ?></label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" name="version" id="version" value="<?= $row->version; ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_status'); ?></label>
                    <div class="col-sm-2 col-md-2">
                        <select name="status" d="status" class="form-control">
                            <option value="1" <?= $row->status  == 1 ? 'selected="selected"' : ''; ?>><?= wpn_lang('wpn_active'); ?></option>
                            <option value="0" <?= $row->status  == 0 ? 'selected="selected"' : ''; ?>><?= wpn_lang('wpn_inactive'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 col-md-offset-2 col-md-10">
                        <button type="submit" class="btn btn-primary" ><?= wpn_lang('wpn_bot_save'); ?></button>
                        <?= anchor('admin/modulos', wpn_lang('wpn_bot_cancel'), array('class' => 'btn btn-danger')); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-header">
                            <?= wpn_lang('wpn_actions'); ?>
                            <button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#myModal">
                                <?= glyphicon('plus-sign') . wpn_lang('wpn_bot_new'); ?>
                            </button>
                        </h2>
                        <?= $actions_list; ?>
                    </div>
                </div>

            <?= form_close(); ?>
        </div>
    </div>
</section>

<!-- Modal Novo Modulo -->
<?= form_open('admin/modulos/addaction/'.$row->id, array('class' => 'form-horizontal')); ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= wpn_lang('module_add_action'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_description'); ?></label>
                    <div class="col-sm-10 col-md-10">
                        <input type="text" name="description" id="description" class="form-control" />
                        <?= form_error('description'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="id" class="col-sm-2 col-md-2 control-label"><?= wpn_lang('field_link'); ?></label>
                    <div class="col-sm-10 col-md-10">
                        <input type="text" name="link" id="link" class="form-control" />
                        <?= form_error('link'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-md-10 col-sm-offset-2 col-md-offset-2">
                        <label>
                            <input type="checkbox" name="whitelist" value="1" />
                            <?= wpn_lang('field_whitelist'); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
                <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>