<section class="content-header">
    <h1>
        <?= wpn_lang('profile_title'); ?>
        <small><?= wpn_lang('profile_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?= wpn_lang('wpn_menu_dashboard'); ?></a></li>
        <li><?= wpn_lang('profile_title'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= wpn_lang('profile_description'); ?></h3>
        </div>
        <div class="box-body">
            <?= form_open_multipart('admin/accounts/profile', array('role'=>'form')); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name"><?= wpn_lang('field_name'); ?></label>
                            <input type="text" name="name" value="<?= $extra->name; ?>" class="form-control" />
                            <?= form_error('name'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email"><?= wpn_lang('field_email'); ?></label>
                            <input type="email" name="email" value="<?= $row->email; ?>" class="form-control" />
                            <?= form_error('email'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="thumbnail">
                            <?php if($extra->avatar){ ?>
                                <img src="<?= base_url('media/avatar/'.$extra->avatar); ?>" class="img-responsive" />
                            <?php } else { ?>
                                <img src="<?= base_url('lib/img/no-user.jpg'); ?>" class="img-responsive" />
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userfile"><?= wpn_lang('field_avatar'); ?></label>
                            <input type="file" name="userfile" class="form-control" />
                            <input type="hidden" name="avatar" value="<?= $extra->avatar; ?>"/>
                            <div class="checkbox">
                                <label>
                                    <?= form_checkbox('change_avatar', '1', false); ?>
                                    <?= wpn_lang('field_change_avatar'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <?php
                            // Opções de skin
                            $options = array(
                              'black'  => 'Black',
                              'black-light'  => 'Black-Light',
                              'blue'  => 'Blue',
                              'blue-light'  => 'Blue-Light',
                              'green'  => 'Green',
                              'green-light'  => 'Green-Light',
                              'purple'  => 'Purple',
                              'purple-light'  => 'Purple-Light',
                              'red'  => 'Red',
                              'red-light'  => 'Red-Light',
                              'yellow'  => 'Yellow',
                              'yellow-light'  => 'Yellow-Light'
                            );
                            ?>
                            <label for="skin"><?= wpn_lang('field_skin'); ?></label>
                            <?= form_dropdown('skin', $options, array($extra->skin), array('class'=>'form-control')); ?>
                            <?= form_error('skin'); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-primary"><?= wpn_lang('wpn_bot_save'); ?></button>
                        <?= anchor('admin/dashboard', wpn_lang('wpn_bot_cancel'), array('class'=>'btn btn-danger')); ?>
                        <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target=".change-password-modal"><span class="glyphicon glyphicon-exclamation-sign"></span> <?= wpn_lang('bot_change_password'); ?></button>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>

<?= form_open('admin/accounts/changeprofilepassword'); ?>
<div class="modal fade change-password-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?= wpn_lang('modal_change_password'); ?>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="new_password"><?= wpn_lang('field_new_password'); ?></label>
                            <input type="password" name="new_password" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="confirm_password"><?= wpn_lang('field_confirm_password'); ?></label>
                            <input type="password" name="confirm_password" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="original_password"><?= wpn_lang('field_original_password'); ?></label>
                            <input type="password" name="original_password" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?= wpn_lang('wpn_bot_save'); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= wpn_lang('wpn_bot_cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>